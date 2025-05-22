<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $visitors = Visitor::query()
                ->with(['general', 'internship', 'recurring']);

            if ($request->filled('status') && $request->input('status') !== 'All') {
                $visitors->where('status', $request->input('status'));
            }

            if ($request->filled('type') && $request->input('type') !== 'All') {
                $visitors->where('type', $request->input('type'));
            }

            $visitors = $visitors->latest()->take(5)->get();

            return DataTables::of($visitors)->make(true);
        }


        $periode = $request->get('periode', 'today');

        switch ($periode) {
            case 'this_week':
                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                $prevStart = now()->subWeek()->startOfWeek();
                $prevEnd = now()->subWeek()->endOfWeek();
                break;
            case 'this_month':
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                $prevStart = now()->subMonth()->startOfMonth();
                $prevEnd = now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $start = now()->startOfYear();
                $end = now()->endOfYear();
                $prevStart = now()->subYear()->startOfYear();
                $prevEnd = now()->subYear()->endOfYear();
                break;
            case 'today':
            default:
                $start = now()->startOfDay();
                $end = now()->endOfDay();
                $prevStart = now()->subDay()->startOfDay();
                $prevEnd = now()->subDay()->endOfDay();
                break;
        }

        $mostVisited = DB::table('visitor_generals')
            ->whereBetween('visit_date', [$start, $end])
            ->select('person_to_meet', DB::raw('count(*) as total'))
            ->groupBy('person_to_meet')
            ->orderByDesc('total')
            ->first();

        $currentTotal = DB::table('visitors')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $previousTotal = DB::table('visitors')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->count();

        // Hitung persentase perubahan
        if ($previousTotal == 0) {
            $percentageChange = $currentTotal > 0 ? 100 : 0;
        } else {
            $percentageChange = round((($currentTotal - $previousTotal) / $previousTotal) * 100);
        }



        $daily = DB::table('visitors')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $dayLabels = [];
        $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayLabels[] = now()->subDays($i)->translatedFormat('D'); // e.g. Sen, Sel
            $dailyData[] = $daily[$date]->total ?? 0;
        }

        // 5 Minggu Terakhir
        $weekly = DB::table('visitors')
            ->selectRaw('YEARWEEK(created_at, 1) as yearweek, COUNT(*) as total')
            ->where('created_at', '>=', now()->subWeeks(4)->startOfWeek())
            ->groupBy('yearweek')
            ->orderBy('yearweek')
            ->get();

        $weekLabels = [];
        $weeklyData = [];
        foreach ($weekly as $key => $row) {
            $weekLabels[] = "Minggu " . ($key + 1);
            $weeklyData[] = $row->total;
        }

        // 6 Bulan Terakhir
        $monthly = DB::table('visitors')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m")')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $monthLabels = [];
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $monthLabels[] = now()->subMonths($i)->translatedFormat('F');
            $monthlyData[] = $monthly[$month]->total ?? 0;
        }

        // Distribusi Berdasarkan Departemen
        $departments = DB::table(function ($query) {
            $query->select('department')
                ->from('visitor_generals')
                ->unionAll(
                    DB::table('visitor_internships')->select('department')
                )
                ->unionAll(
                    DB::table('visitor_recurrings')->select('department')
                );
        }, 'all_visitors')
            ->select('department', DB::raw('COUNT(*) as total'))
            ->groupBy('department')
            ->get();

        $totalVisitors = $departments->sum('total');

        $visitorsByDepartment = $departments->map(function ($item) use ($totalVisitors) {
            return [
                'department' => $item->department,
                'count' => $item->total,
                'percentage' => $totalVisitors > 0 ? round(($item->total / $totalVisitors) * 100, 1) : 0,
            ];
        });


        $reactionCounts = Reaction::select('name', \DB::raw('count(*) as total'))
    ->groupBy('name')
    ->get();



        $durations = [];

        $generalVisitors = Visitor::where('status', 'Inactive')
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




        return view('report', [
            'topHost' => $mostVisited->person_to_meet ?? 'Tidak Ada',
            'topHostCount' => $mostVisited->total ?? 0,
            'averageDuration' => $averageDuration,
            'currentTotal' => $currentTotal,
            'percentageChange' => $percentageChange,
            'dayLabels' => $dayLabels,
            'dailyData' => $dailyData,
            'weekLabels' => $weekLabels,
            'weeklyData' => $weeklyData,
            'monthLabels' => $monthLabels,
            'monthlyData' => $monthlyData,
            'visitorsByDepartment' => $visitorsByDepartment,
            'totalVisitors' => $totalVisitors,
            'dailyReports' => $this->dailyReports(),
            'weeklyReports' => $this->weeklyReports(),
            'monthlyReports' => $this->monthlyReports(),
            'reactionCounts'=> $reactionCounts,
            'periode' => $periode,
        ]);
    }

    public function dailyReports()
    {
        $startDate = Carbon::today()->subDays(13);
        $endDate = Carbon::today();
        $dates = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }
        return $dates->map(function ($date) {
            // === General Visitors ===
            $general = DB::table('visitor_generals')
                ->join('visitors', 'visitor_generals.visitor_id', '=', 'visitors.id')
                ->whereDate('visit_date', $date)
                ->select('visitor_generals.*', 'visitors.status')
                ->get();


            $generalTotal = $general->count();
            // $generalCheckin = $general->whereNotNull('visit_time')->count();
            // $generalCheckout = $general->whereNotNull('exit_time')->count();
            $generalCheckin = $general->where('status', 'Active')->count();
            $generalCheckout = $general->where('status', 'Inactive')->count();
            $generalDurations = $general->map(function ($v) {
                if ($v->visit_time && $v->exit_time) {
                    return Carbon::parse($v->exit_time)->diffInMinutes(Carbon::parse($v->visit_time));
                }
                return 0;
            });

            // === Internship Visitors ===
            $internship = DB::table('visitor_internships')
                ->join('visitors', 'visitor_internships.visitor_id', '=', 'visitors.id')
                ->whereDate('internship_start', '<=', $date)
                ->whereDate('internship_end', '>=', $date)
                ->select('visitor_internships.*', 'visitors.status')
                ->get();

            $internshipTotal = $internship->count();
            // $internshipCheckin = $internshipTotal;
            $internshipCheckin = $internship->where('status', 'Active')->count();
            $internshipCheckout = $internship->where('status', 'Inactive')->count();
            $internshipDurations = collect();
            // $internshipDurations = collect()->pad($internshipTotal, 0, 480);

            // === Recurring Visitors ===
            $recurring = DB::table('visitor_recurrings')
                ->join('visitors', 'visitor_recurrings.visitor_id', '=', 'visitors.id')
                ->whereDate('access_start', '<=', $date)
                ->whereDate('access_end', '>=', $date)
                ->select('visitor_recurrings.*', 'visitors.status')
                ->get();

            $recurringTotal = $recurring->count();
            // $recurringCheckin = $recurring->whereNotNull('usual_entry_time')->count();
            // $recurringCheckout = $recurring->whereNotNull('usual_exit_time')->count();
            $recurringCheckin = $recurring->where('status', 'Active')->count();
            $recurringCheckout = $recurring->where('status', 'Inactive')->count();
            $recurringDurations = $recurring->map(function ($v) {
                if ($v->usual_entry_time && $v->usual_exit_time) {
                    return Carbon::parse($v->usual_exit_time)->diffInMinutes(Carbon::parse($v->usual_entry_time));
                }
                return 0;
            });

            // Combine all
            $total = $generalTotal + $internshipTotal + $recurringTotal;
            $checkin = $generalCheckin + $internshipCheckin + $recurringCheckin;
            $checkout = $generalCheckout + $internshipCheckout + $recurringCheckout;

            $allDurations = $generalDurations->merge($recurringDurations);
            $averageDuration = $allDurations->count() ? round($allDurations->avg()) : 0;

            return (object) [
                'date' => $date,
                'total' => $total,
                'checkin' => $checkin,
                'checkout' => $checkout,
                'average_duration' => $averageDuration,
            ];
        });
    }

    public function weeklyReports()
    {
        $weeklyReports = collect();

        for ($i = 7; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->startOfWeek()->subWeeks($i);
            $endOfWeek = Carbon::now()->endOfWeek()->subWeeks($i);

            // === General Visitors ===
            $general = DB::table('visitor_generals')
                ->join('visitors', 'visitor_generals.visitor_id', '=', 'visitors.id')
                ->whereBetween('visit_date', [$startOfWeek, $endOfWeek])
                ->select('visitor_generals.*', 'visitors.status')
                ->get();

            $generalTotal = $general->count();
            $generalCheckin = $general->where('status', 'Active')->count();
            $generalCheckout = $general->where('status', 'Inactive')->count();
            $generalDurations = $general->map(function ($v) {
                if ($v->visit_time && $v->exit_time) {
                    return Carbon::parse($v->exit_time)->diffInMinutes(Carbon::parse($v->visit_time));
                }
                return 0;
            });

            // === Internship Visitors ===
            $internship = DB::table('visitor_internships')
                ->join('visitors', 'visitor_internships.visitor_id', '=', 'visitors.id')
                ->whereDate('internship_start', '<=', $endOfWeek)
                ->whereDate('internship_end', '>=', $startOfWeek)
                ->select('visitor_internships.*', 'visitors.status')
                ->get();

            $internshipTotal = $internship->count();
            $internshipCheckin = $internship->where('status', 'Active')->count();
            $internshipCheckout = $internship->where('status', 'Inactive')->count();
            $internshipDurations = collect(); // Jika tidak dihitung, bisa diisi default 480 menit per hari.

            // === Recurring Visitors ===
            $recurring = DB::table('visitor_recurrings')
                ->join('visitors', 'visitor_recurrings.visitor_id', '=', 'visitors.id')
                ->whereDate('access_start', '<=', $endOfWeek)
                ->whereDate('access_end', '>=', $startOfWeek)
                ->select('visitor_recurrings.*', 'visitors.status')
                ->get();

            $recurringTotal = $recurring->count();
            $recurringCheckin = $recurring->where('status', 'Active')->count();
            $recurringCheckout = $recurring->where('status', 'Inactive')->count();
            $recurringDurations = $recurring->map(function ($v) {
                if ($v->usual_entry_time && $v->usual_exit_time) {
                    return Carbon::parse($v->usual_exit_time)->diffInMinutes(Carbon::parse($v->usual_entry_time));
                }
                return 0;
            });

            // Combine all
            $total = $generalTotal + $internshipTotal + $recurringTotal;
            $checkin = $generalCheckin + $internshipCheckin + $recurringCheckin;
            $checkout = $generalCheckout + $internshipCheckout + $recurringCheckout;
            $allDurations = $generalDurations->merge($recurringDurations);
            $averageDuration = $allDurations->count() ? round($allDurations->avg()) : 0;

            $weeklyReports->push((object) [
                'week' => $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M'),
                'total' => $total,
                'checkin' => $checkin,
                'checkout' => $checkout,
                'average_duration' => $averageDuration,
            ]);
        }
        return $weeklyReports;
    }

    public function monthlyReports()
    {
        $monthlyReports = collect();

        for ($i = 11; $i >= 0; $i--) {
            $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
            $endOfMonth = Carbon::now()->subMonths($i)->endOfMonth();

            // === General Visitors ===
            $general = DB::table('visitor_generals')
                ->join('visitors', 'visitor_generals.visitor_id', '=', 'visitors.id')
                ->whereBetween('visit_date', [$startOfMonth, $endOfMonth])
                ->select('visitor_generals.*', 'visitors.status')
                ->get();

            $generalTotal = $general->count();
            $generalCheckin = $general->where('status', 'Active')->count();
            $generalCheckout = $general->where('status', 'Inactive')->count();
            $generalDurations = $general->map(function ($v) {
                if ($v->visit_time && $v->exit_time) {
                    return Carbon::parse($v->exit_time)->diffInMinutes(Carbon::parse($v->visit_time));
                }
                return 0;
            });

            // === Internship Visitors ===
            $internship = DB::table('visitor_internships')
                ->join('visitors', 'visitor_internships.visitor_id', '=', 'visitors.id')
                ->whereDate('internship_start', '<=', $endOfMonth)
                ->whereDate('internship_end', '>=', $startOfMonth)
                ->select('visitor_internships.*', 'visitors.status')
                ->get();

            $internshipTotal = $internship->count();
            $internshipCheckin = $internship->where('status', 'Active')->count();
            $internshipCheckout = $internship->where('status', 'Inactive')->count();
            $internshipDurations = collect();

            // === Recurring Visitors ===
            $recurring = DB::table('visitor_recurrings')
                ->join('visitors', 'visitor_recurrings.visitor_id', '=', 'visitors.id')
                ->whereDate('access_start', '<=', $endOfMonth)
                ->whereDate('access_end', '>=', $startOfMonth)
                ->select('visitor_recurrings.*', 'visitors.status')
                ->get();

            $recurringTotal = $recurring->count();
            $recurringCheckin = $recurring->where('status', 'Active')->count();
            $recurringCheckout = $recurring->where('status', 'Inactive')->count();
            $recurringDurations = $recurring->map(function ($v) {
                if ($v->usual_entry_time && $v->usual_exit_time) {
                    return Carbon::parse($v->usual_exit_time)->diffInMinutes(Carbon::parse($v->usual_entry_time));
                }
                return 0;
            });

            // Combine all
            $total = $generalTotal + $internshipTotal + $recurringTotal;
            $checkin = $generalCheckin + $internshipCheckin + $recurringCheckin;
            $checkout = $generalCheckout + $internshipCheckout + $recurringCheckout;
            $allDurations = $generalDurations->merge($recurringDurations);
            $averageDuration = $allDurations->count() ? round($allDurations->avg()) : 0;

            $monthlyReports->push((object) [
                'month' => $startOfMonth->format('F Y'),
                'total' => $total,
                'checkin' => $checkin,
                'checkout' => $checkout,
                'average_duration' => $averageDuration,
            ]);
        }
        return $monthlyReports;
    }

    public function getVisitor($id)
    {
        $visitor = Visitor::with(['general', 'internship', 'recurring'])->findOrFail($id);

        $html = view('dashboard.partials.visitor-detail', compact('visitor'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function reaction (Request $request)
    {
 if ($request->ajax()) {
            $reactions = Reaction::query()
                ->with(['visitor']);

            return DataTables::of($reactions)->make(true);
        }
    }
}