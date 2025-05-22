<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use App\Enums\VisitorType;
use Illuminate\Http\Request;
use App\Exports\VisitorExport;
use App\Models\VisitorGeneral;
use App\Models\VisitorRecurring;
use App\Models\VisitorInternship;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\VisitorConfirmationMail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\ConfirmationNotification;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $visitors = Visitor::query()->with(['general', 'internship', 'recurring']);

            if ($request->has('status') && $request->input('status') != 'All' && $request->input('status') != NULL) {
                $status = $request->input('status');
                $visitors->where('status', $status);
            }
            if ($request->has('type') && $request->input('type') != 'All' && $request->input('type') != NULL) {
                $type = $request->input('type');
                $visitors->where('type', $type);
            }


            return DataTables::of($visitors)->make();
        }

        return view('dashboard.visitor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.visitor.create');
    }
    public function createOneTime()
    {
        return view('dashboard.visitor.createOneTime');
    }
    public function createInternship()
    {
        return view('dashboard.visitor.createInternship');
    }
    public function createRecurring()
    {
        return view('dashboard.visitor.createRecurring');
    }

    public function storeOneTime(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'identity_number' => 'required|string|max:50',
            'company' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:70',
            'purpose' => 'required|string',
            'person_to_meet' => 'required|string|max:70',
            'department' => 'required|string',
            'visit_date' => 'required|date',
            'exit_date' => 'required|date|after_or_equal:visit_date',
            'visit_time' => 'required',
            'exit_time' => 'required',
            'vehicle_number' => 'nullable|string|max:50',
            'additional_info' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $validated['status'] = 'Pending';
        $validated['type'] = VisitorType::UMUM;


        $fileFilename = null;
        if ($request->hasFile('photo')) {
            $fileFilename = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('visitor/photo', $fileFilename);
        }

        $visitor = Visitor::create([
            'name' => $validated['name'],
            'identity_number' => $validated['identity_number'],
            'photo' => $fileFilename,
            'phone' => $validated['phone'],
            'status' => $validated['status'],
            'type' => $validated['type'],
            'email' => $validated['email'],
        ]);



        // Simpan ke database
        VisitorGeneral::create([
            'visitor_id' => $visitor->id,
            'company' => $validated['company'],
            'purpose' => $validated['purpose'],
            'person_to_meet' => $validated['person_to_meet'],
            'department' => $validated['department'],
            'visit_date' => $validated['visit_date'],
            'exit_date' => $validated['exit_date'],
            'visit_time' => $validated['visit_time'],
            'exit_time' => $validated['exit_time'],
            'vehicle_number' => $validated['vehicle_number'],
            'additional_info' => $validated['additional_info'],
        ]);
        return redirect('/dashboard/visitor')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function storeInternship(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'identity_number' => 'required|string|max:50',
            'institution' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:70',
            'supervisor' => 'nullable|string|max:70',
            'emergency_contact_name' => 'required|string|max:70',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_contact_relation' => 'required|string',
            'department' => 'required|string',
            'internship_start' => 'required|date',
            'internship_end' => 'required|date|after_or_equal:internship_start',
            'additional_info' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'referral_letter' => 'required|mimes:pdf|max:4096',
        ]);

        $validated['status'] = 'Pending';
        $validated['type'] = VisitorType::MAGANG;


        $fileFilename = null;
        if ($request->hasFile('photo')) {
            $fileFilename = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('visitor/photo', $fileFilename);
        }

        $suratPengantar = null;
        if ($request->hasFile('referral_letter')) {
            $suratPengantar = time() . '.pdf';
            $request->file('referral_letter')->storeAs('visitor/referral_letter', $suratPengantar);
        }

        $visitor = Visitor::create([
            'name' => $validated['name'],
            'identity_number' => $validated['identity_number'],
            'photo' => $fileFilename,
            'phone' => $validated['phone'],
            'status' => $validated['status'],
            'type' => $validated['type'],
            'email' => $validated['email'],
        ]);


        // Simpan ke database
        VisitorInternship::create([
            'visitor_id' => $visitor->id,
            'institution' => $validated['institution'],
            'supervisor' => $validated['supervisor'],
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_phone' => $validated['emergency_contact_phone'],
            'emergency_contact_relation' => $validated['emergency_contact_relation'],
            'department' => $validated['department'],
            'internship_start' => $validated['internship_start'],
            'internship_end' => $validated['internship_end'],
            'referral_letter' => $suratPengantar,
            'additional_info' => $validated['additional_info'],
        ]);

        return redirect('/dashboard/visitor')->with('success', 'Data Berhasil Ditambahkan');
    }
    public function storeRecurring(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'identity_number' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:70',
            'company' => 'nullable|string|max:255',
            'recurring_type' => 'required|string',
            'related_to' => 'required|string|max:70',
            'relation' => 'required|string',
            'department' => 'required|string',
            'access_start' => 'required|date',
            'access_end' => 'required|date|after_or_equal:access_start',
            'vehicle_number' => 'nullable|string',
            'visit_days' => 'required|array|min:1',
            'visit_days.*' => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'usual_entry_time' => 'required',
            'usual_exit_time' => 'required',
            'additional_info' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $validated['status'] = 'Pending';
        $validated['type'] = VisitorType::TAMU_BERULANG;


        $fileFilename = null;
        if ($request->hasFile('photo')) {
            $fileFilename = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('visitor/photo', $fileFilename);
        }

        $visitor = Visitor::create([
            'name' => $validated['name'],
            'identity_number' => $validated['identity_number'],
            'photo' => $fileFilename,
            'phone' => $validated['phone'],
            'status' => $validated['status'],
            'type' => $validated['type'],
            'email' => $validated['email'],
        ]);


        // Simpan ke database
        VisitorRecurring::create([
            'visitor_id' => $visitor->id,
            'company' => $validated['company'],
            'recurring_type' => $validated['recurring_type'],
            'related_to' => $validated['related_to'],
            'relation' => $validated['relation'],
            'access_start' => $validated['access_start'],
            'access_end' => $validated['access_end'],
            'department' => $validated['department'],
            'vehicle_number' => $validated['vehicle_number'],
            'usual_entry_time' => $validated['usual_entry_time'],
            'usual_exit_time' => $validated['usual_exit_time'],
            'visit_days' => json_encode($validated['visit_days']),
            'additional_info' => $validated['additional_info'],
        ]);

        return redirect('/dashboard/visitor')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitor $visitor)
    {
        if ($visitor->type->value == 'Tamu Umum') {
            return view('dashboard.visitor.editOneTime', compact('visitor'));
        } else if ($visitor->type->value == 'Magang') {
            return view('dashboard.visitor.editInternship', compact('visitor'));
        } else if ($visitor->type->value == 'Tamu Berulang') {
            return view('dashboard.visitor.editRecurring', compact('visitor'));
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOneTime(Request $request, Visitor $visitor)
    {
        $rules = [
            'name' => 'required|string|max:70',
            'identity_number' => 'required|string|max:50',
            'company' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:70',
            'purpose' => 'required|string',
            'person_to_meet' => 'required|string|max:70',
            'department' => 'required|string',
            'visit_date' => 'required|date',
            'exit_date' => 'required|date|after_or_equal:visit_date',
            'visit_time' => 'required',
            'exit_time' => 'required',
            'vehicle_number' => 'nullable|string|max:50',
            'additional_info' => 'nullable|string',
        ];
        $validated = $request->validate($rules);

        $visitor->update([
            'name' => $validated['name'],
            'identity_number' => $validated['identity_number'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
        ]);



        // Simpan ke database
        $visitor->general->update([
            'company' => $validated['company'],
            'purpose' => $validated['purpose'],
            'person_to_meet' => $validated['person_to_meet'],
            'department' => $validated['department'],
            'visit_date' => $validated['visit_date'],
            'exit_date' => $validated['exit_date'],
            'visit_time' => $validated['visit_time'],
            'exit_time' => $validated['exit_time'],
            'vehicle_number' => $validated['vehicle_number'],
            'additional_info' => $validated['additional_info'],
        ]);
        return redirect('/dashboard/visitor')->with('success', 'Data Berhasil Diupdate');
    }

    public function updateInternship(Request $request, Visitor $visitor)
    {
        $rules = [
            'name' => 'required|string|max:70',
            'identity_number' => 'required|string|max:50',
            'institution' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:70',
            'supervisor' => 'nullable|string|max:70',
            'emergency_contact_name' => 'required|string|max:70',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_contact_relation' => 'required|string',
            'department' => 'required|string',
            'internship_start' => 'required|date',
            'internship_end' => 'required|date|after_or_equal:internship_start',
            'additional_info' => 'nullable|string',
        ];

        $validated = $request->validate($rules);


        $visitor->update([
            'name' => $validated['name'],
            'identity_number' => $validated['identity_number'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
        ]);


        // Simpan ke database
        $visitor->internship->update([
            'institution' => $validated['institution'],
            'supervisor' => $validated['supervisor'],
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_phone' => $validated['emergency_contact_phone'],
            'emergency_contact_relation' => $validated['emergency_contact_relation'],
            'department' => $validated['department'],
            'internship_start' => $validated['internship_start'],
            'internship_end' => $validated['internship_end'],
            'additional_info' => $validated['additional_info'],
        ]);

        return redirect('/dashboard/visitor')->with('success', 'Data Berhasil Diupdate');
    }
    public function updateRecurring(Request $request, Visitor $visitor)
    {
        $rules = [
            'name' => 'required|string|max:70',
            'identity_number' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:70',
            'company' => 'nullable|string|max:255',
            'recurring_type' => 'required|string',
            'related_to' => 'required|string|max:70',
            'relation' => 'required|string',
            'department' => 'required|string',
            'access_start' => 'required|date',
            'access_end' => 'required|date|after_or_equal:access_start',
            'vehicle_number' => 'nullable|string',
            'visit_days' => 'required|array|min:1',
            'visit_days.*' => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'usual_entry_time' => 'required',
            'usual_exit_time' => 'required',
            'additional_info' => 'nullable|string',
        ];

        $validated = $request->validate($rules);

        $visitor->update([
            'name' => $validated['name'],
            'identity_number' => $validated['identity_number'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
        ]);


        // Simpan ke database
        $visitor->recurring->update([
            'visitor_id' => $visitor->id,
            'company' => $validated['company'],
            'recurring_type' => $validated['recurring_type'],
            'related_to' => $validated['related_to'],
            'relation' => $validated['relation'],
            'access_start' => $validated['access_start'],
            'access_end' => $validated['access_end'],
            'department' => $validated['department'],
            'vehicle_number' => $validated['vehicle_number'],
            'usual_entry_time' => $validated['usual_entry_time'],
            'usual_exit_time' => $validated['usual_exit_time'],
            'visit_days' => json_encode($validated['visit_days']),
            'additional_info' => $validated['additional_info'],
        ]);

        return redirect('/dashboard/visitor')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitor $visitor)
    {
        if ($visitor->photo) {
            Storage::delete('visitor/photo/' . $visitor->photo);
        }
        $visitor?->general?->delete();
        $visitor?->internship?->delete();
        $visitor?->recurring?->delete();
        Visitor::destroy($visitor->id);

        return redirect('/dashboard/visitor')->with('success', 'Tamu Berhasil Dihapus!');
    }

    public function export(Request $request)
    {
        $status = $request->statusExport;
        $type = $request->typeExport;
        return Excel::download(new VisitorExport($status, $type), 'Data Tamu.xlsx');

    }

    public function updateStatus(Request $request, $id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->status = $request->status;
        $visitor->save();

        $users = User::all();

        if ($visitor->type->value != 'Tamu Umum') {
            if ($visitor->status != 'Pending' || $visitor->status != 'Inactive') {
                foreach ($users as $user) {
                    $user->notify(new ConfirmationNotification($visitor));
                }
                Mail::to($visitor->email)->send(new VisitorConfirmationMail($visitor));
            }
        }


        return response()->json(['success' => true]);
    }

    public function getVisitor($id)
    {
        $visitor = Visitor::with(['general', 'internship', 'recurring'])->findOrFail($id);

        $html = view('dashboard.partials.visitor-detail', compact('visitor'))->render();

        return response()->json([
            'html' => $html
        ]);
    }


}