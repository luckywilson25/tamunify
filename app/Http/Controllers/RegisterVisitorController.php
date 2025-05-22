<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\User;
use App\Models\Visitor;
use App\Enums\VisitorType;
use Illuminate\Http\Request;
use App\Models\VisitorGeneral;
use App\Models\VisitorRecurring;
use App\Models\VisitorInternship;
use Illuminate\Support\Facades\Mail;
use App\Mail\VisitorRegisteredUserMail;
use Illuminate\Support\Facades\Storage;
use App\Notifications\RegisterNotification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegisterVisitorController extends Controller
{
    public function registerOneTime()
    {
        return view('register.one-time');
    }

    public function registerRecurring()
    {
        return view('register.recurring');
    }

    public function registerInternship()
    {
        return view('register.internship');
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
            'purpose_more' => 'nullable|string',
            'person_to_meet' => 'required|string|max:70',
            'department' => 'required|string',
            'department_more' => 'nullable|string',
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

        $qrImageName = 'qr_' . $visitor->id . '.png';
        QrCode::format('png')->size(500)->color(21, 128, 61)->generate($visitor->uuid, Storage::path('qrcodes/' . $qrImageName));
        $qrCode = QrCode::size(100)->color(21, 128, 61)->generate($visitor->uuid);



        // Simpan ke database
        VisitorGeneral::create([
            'visitor_id' => $visitor->id,
            'company' => $validated['company'],
            'purpose' => $validated['purpose'],
            'purpose_more' => $validated['purpose_more'],
            'person_to_meet' => $validated['person_to_meet'],
            'department' => $validated['department'],
            'department_more' => $validated['department_more'],
            'visit_date' => $validated['visit_date'],
            'exit_date' => $validated['exit_date'],
            'visit_time' => $validated['visit_time'],
            'exit_time' => $validated['exit_time'],
            'vehicle_number' => $validated['vehicle_number'],
            'additional_info' => $validated['additional_info'],
        ]);
        $users = User::all();

        foreach ($users as $user) {
            $user->notify(new RegisterNotification($visitor));
        }
        // Mail::to($visitor->email)->send(new VisitorRegisteredUserMail($visitor, $qrCode));

        return redirect('/one-time/success')->with('data', [
            'qrCode' => $qrCode,
            'visitor' => $visitor,
            'qrCodePath' => asset('storage/qrcodes/' . $qrImageName),
        ]);
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
            'department' => 'required|string',
    'department_more' => 'nullable|string',
    'emergency_contact_relation' => 'required|string',
    'emergency_contact_relation_more' => 'nullable|string',
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
            'emergency_contact_relation_more' => $validated['emergency_contact_relation_more'],
            'department' => $validated['department'],
            'department_more' => $validated['department_more'],
            'internship_start' => $validated['internship_start'],
            'internship_end' => $validated['internship_end'],
            'referral_letter' => $suratPengantar,
            'additional_info' => $validated['additional_info'],
        ]);
        $users = User::all();

        foreach ($users as $user) {
            $user->notify(new RegisterNotification($visitor));
        }
        Mail::to($visitor->email)->send(new VisitorRegisteredUserMail($visitor, '-'));

        return redirect('/internship/success')->with('data', [
            'visitor' => $visitor,
        ]);
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
            'recurring_type_more' => 'nullable|string',
            'related_to' => 'required|string|max:70',
            'relation' => 'required|string',
            'relation_more' => 'nullable|string',
            'department' => 'required|string',
            'department_more' => 'nullable|string',
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
            'recurring_type_more' => $validated['recurring_type_more'],
            'related_to' => $validated['related_to'],
            'relation' => $validated['relation'],
            'relation_more' => $validated['relation_more'],
            'access_start' => $validated['access_start'],
            'access_end' => $validated['access_end'],
            'department' => $validated['department'],
            'department_more' => $validated['department_more'],
            'vehicle_number' => $validated['vehicle_number'],
            'usual_entry_time' => $validated['usual_entry_time'],
            'usual_exit_time' => $validated['usual_exit_time'],
            'visit_days' => json_encode($validated['visit_days']),
            'additional_info' => $validated['additional_info'],
        ]);
        $users = User::all();

        foreach ($users as $user) {
            $user->notify(new RegisterNotification($visitor));
        }
        Mail::to($visitor->email)->send(new VisitorRegisteredUserMail($visitor, '-'));

        return redirect('/recurring/success')->with('data', [
            'visitor' => $visitor,
        ]);
    }

    public function storeReaction(Request $request)
{
    $request->validate([
        'visitor_id' => 'required|string',
        'rating' => 'required',
        'feedback' => 'required|string',
    ]);

    // Simpan ke database (atau sesuaikan dengan kebutuhan)
    Reaction::create([
        'visitor_id' => $request->visitor_id,
        'name' => $request->rating,
        'note' => $request->feedback,
    ]);

    return back()->with('success', 'Terima kasih atas feedback Anda!');
}

    public function successOneTime()
    {
        return view('register.success.one-time');
    }

    public function successInternship()
    {
        return view('register.success.internship');
    }

    public function successRecurring()
    {
        return view('register.success.recurring');
    }
}