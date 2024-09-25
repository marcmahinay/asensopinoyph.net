<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\MunicityController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssistanceTypeController;
use App\Http\Controllers\AssistanceEventController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/beneficiaries/search', [BeneficiaryController::class, 'search']);
    Route::get('/provinces/{province}/municities', [ProvinceController::class, 'municities']);

    Route::resource('provinces', ProvinceController::class);
    Route::resource('municities', MunicityController::class);
    Route::resource('barangays', BarangayController::class);
    Route::resource('beneficiaries', BeneficiaryController::class);
    Route::resource('assistance-types', AssistanceTypeController::class);
    Route::resource('assistance-events', AssistanceEventController::class);
    Route::resource('assistance-schedule', AssistanceEventController::class);

    Route::get('/member/{asenso_id}', [BeneficiaryController::class, 'showByAsensoId']);
    Route::get('/search/barangay', [BarangayController::class, 'search']);
    Route::post('/assistance/cancel', [AssistanceEventController::class, 'cancel'])->name('assistance.cancel');
    Route::post('/assistance/receive', [AssistanceEventController::class, 'receive'])->name('assistance.receive');
    Route::get('/qr-scanner', [QrCodeController::class, 'qrScanner'])->name('qr.qrScanner');
    Route::post('/scan-qr-code', [QrCodeController::class, 'verify'])->name('qr.verify');
});

require __DIR__ . '/auth.php';
