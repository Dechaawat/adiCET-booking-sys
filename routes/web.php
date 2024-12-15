<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
Route::get('/', function () {
    return view('welcome');
});


Route::resource('rooms', RoomController::class);
Route::resource('equipment', EquipmentController::class);
Route::resource('bookings', BookingController::class);
Route::put('bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
Route::put('bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

// Public Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    Route::get('/user-dashboard', function () {
        return view('Userdashboard');
    })->name('user.dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('AdminDashboard');
    })->name('admin.dashboard');
});