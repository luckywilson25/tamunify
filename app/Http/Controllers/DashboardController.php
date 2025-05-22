<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Exports\VisitorExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\VisitorConfirmationMail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\ConfirmationNotification;

class DashboardController extends Controller
{
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


        $totalVisitorToday = Visitor::whereDate('created_at', now())
            ->count();

        $visitorActive = Visitor::where('status', 'Active')
            ->count();
        $internshipActive = Visitor::where('status', 'Active')->where('type', 'Magang')
            ->count();
        $recurringActive = Visitor::where('status', 'Active')->where('type', 'Tamu Berulang')
            ->count();

        // Tamu Umum
        $generalCount = Visitor::where('status', 'Active')
            ->where('type', 'Tamu Umum')
            ->count();

        // Peserta Magang
        $internshipCount = Visitor::where('status', 'Active')
            ->where('type', 'Magang')
            ->count();

        // Tamu Berulang
        $recurringCount = Visitor::where('status', 'Active')
            ->where('type', 'Tamu Berulang')
            ->count();

        // Total Tamu Aktif dari semua relasi dengan departemen sesuai user
        $totalActive = Visitor::where('status', 'Active')
            ->count();

        // Rata-rata durasi kunjungan
        $durations = [];

        $generalVisitors = Visitor::where('status', 'Active')
            ->where('type', 'Tamu Umum')
            ->with('general')->get();

        foreach ($generalVisitors as $visitor) {
            $start = strtotime($visitor->general->visit_time);
            $end = strtotime($visitor->general->exit_time);
            if ($start && $end && $end > $start) {
                $durations[] = ($end - $start) / 60; // in minutes
            }
        }

        $averageDuration = count($durations) > 0 ? round(array_sum($durations) / count($durations), 2) : 0;

        return view('dashboard', [
            'totalVisitorToday' => $totalVisitorToday,
            'visitorActive' => $visitorActive,
            'internshipActive' => $internshipActive,
            'recurringActive' => $recurringActive,
            'generalCount' => $generalCount,
            'internshipCount' => $internshipCount,
            'recurringCount' => $recurringCount,
            'totalActive' => $totalActive,
            'averageDuration' => $averageDuration
        ]);
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

    public function destroy(Visitor $visitor)
    {
        if ($visitor->photo) {
            Storage::delete('visitor/photo/' . $visitor->photo);
        }
        $visitor?->general?->delete();
        $visitor?->internship?->delete();
        $visitor?->recurring?->delete();
        Visitor::destroy($visitor->id);

        return redirect('/dashboard')->with('success', 'Tamu Berhasil Dihapus!');
    }


    public function process(Request $request)
    {
        // $parser = null;
        // if ($request->qr_code) {
        //     $parser = json_decode($request->qr_code, true);
        // }
        $visitor = Visitor::where('uuid', $request?->qr_code)
            ->first();

        $visitor->status = 'Active';
        $visitor->save();

        return response()->json(['message' => 'Status Berhasil Diupdate', 'success' => true], 200);
    }
}