<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/catalogue', [ProductController::class, 'index'])->name('catalogue');
Route::get('/location-panneaux-solaires', fn () => redirect()->route('catalogue', ['category_slug' => 'panneaux']));
Route::get('/location-batterie', fn () => redirect()->route('catalogue', ['category_slug' => 'batteries']));
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/packs', [PackController::class, 'index'])->name('packs.index');
Route::get('/packs/{pack}', [PackController::class, 'show'])->name('packs.show');

Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
Route::get('/calculateur-energie', fn () => redirect()->route('calculator.index'));
Route::post('/calculator/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');
Route::get('/calculator/result/{quote}', [CalculatorController::class, 'result'])->name('calculator.result');

Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation.create');
Route::get('/reservation/unavailable-dates', [ReservationController::class, 'unavailableDates'])->name('reservation.unavailable-dates');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservation/{reservation}/confirmation', [ReservationController::class, 'success'])->name('reservation.success');

Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/conditions', [PageController::class, 'conditions'])->name('conditions');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [ClientAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [ClientAuthController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'send'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/email/verify', fn () => view('auth.verify-email'))->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('client.profile')->with('success', 'Votre adresse e-mail est vérifiée.');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Un nouveau lien de vérification a été envoyé.');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth', 'client', 'verified'])->prefix('client')->name('client.')->group(function () {
    Route::get('/profile', [ClientProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ClientProfileController::class, 'update'])->name('profile.update');
    Route::get('/reservations', [ClientProfileController::class, 'reservations'])->name('reservations');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', Admin\ProductController::class)->except('show');
    Route::resource('packs', Admin\PackController::class)->except('show');
    Route::get('reservations', [Admin\ReservationController::class, 'index'])->name('reservations.index');
    Route::get('reservations/{reservation}', [Admin\ReservationController::class, 'show'])->name('reservations.show');
    Route::patch('reservations/{reservation}/status', [Admin\ReservationController::class, 'updateStatus'])->name('reservations.status');
    Route::get('availability', [Admin\AvailabilityController::class, 'index'])->name('availability.index');
    Route::get('appliances', [Admin\ApplianceController::class, 'index'])->name('appliances.index');
    Route::post('appliances', [Admin\ApplianceController::class, 'store'])->name('appliances.store');
    Route::delete('appliances/{appliance}', [Admin\ApplianceController::class, 'destroy'])->name('appliances.destroy');
    Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    Route::resource('clients', Admin\ClientController::class)->except('show');
});
