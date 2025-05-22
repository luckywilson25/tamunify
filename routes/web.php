<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisterVisitorController;

// Halaman publik
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/check-in', function () {
    return view('check-in');
})->name('checkin');

Route::get('/one-time', [RegisterVisitorController::class, 'registerOneTime'])->name('register.one-time');
Route::get('/recurring', [RegisterVisitorController::class, 'registerRecurring'])->name('register.recurring');
Route::get('/internship', [RegisterVisitorController::class, 'registerInternship'])->name('register.internship');

Route::get('/one-time/success', [RegisterVisitorController::class, 'successOneTime'])->name('success.one-time');
Route::get('/internship/success', [RegisterVisitorController::class, 'successInternship'])->name('success.internship');
Route::get('/recurring/success', [RegisterVisitorController::class, 'successRecurring'])->name('success.recurring');

Route::post('/internship', [RegisterVisitorController::class, 'storeInternship'])->name('store.internship');
Route::post('/one-time', [RegisterVisitorController::class, 'storeOneTime'])->name('store.one-time');
Route::post('/recurring', [RegisterVisitorController::class, 'storeRecurring'])->name('store.recurring');
Route::post('/reaction', [RegisterVisitorController::class, 'storeReaction'])->name('store.reaction');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect(config('app.frontend_url') . '/?verified=1');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/get/visitor/{id}', [DashboardController::class, 'getVisitor'])->name('dashboard.getVisitor');
    Route::post('/export', [DashboardController::class, 'export'])->name('dashboard.export');
    Route::post('/update-status/{id}', [DashboardController::class, 'updateStatus']);
    Route::delete('/destroy/{visitor}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');
    Route::post('/process-qr-code', [DashboardController::class, 'process']);

    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    Route::post('/notifications/read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    })->name('notifications.markAsRead');

    Route::resource('/admin', AdminController::class)->except('show');
    Route::resource('/visitor', VisitorController::class)->except('show');

    Route::get('/visitor/create/one-time', [VisitorController::class, 'createOneTime'])->name('visitor.create.one-time');
    Route::get('/visitor/create/internship', [VisitorController::class, 'createInternship'])->name('visitor.create.internship');
    Route::get('/visitor/create/recurring', [VisitorController::class, 'createRecurring'])->name('visitor.create.recurring');

    Route::post('/visitor/create/one-time', [VisitorController::class, 'storeOneTime'])->name('visitor.store.one-time');
    Route::post('/visitor/create/internship', [VisitorController::class, 'storeInternship'])->name('visitor.store.internship');
    Route::post('/visitor/create/recurring', [VisitorController::class, 'storeRecurring'])->name('visitor.store.recurring');

    Route::put('/visitor/one-time/{visitor}', [VisitorController::class, 'updateOneTime'])->name('visitor.update.one-time');
    Route::put('/visitor/internship/{visitor}', [VisitorController::class, 'updateInternship'])->name('visitor.update.internship');
    Route::put('/visitor/recurring/{visitor}', [VisitorController::class, 'updateRecurring'])->name('visitor.update.recurring');

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/reaction', [ReportController::class, 'reaction'])->name('report.reaction');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';