<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BarberController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Models\Barber;
use App\Models\Work;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\WelcomeController;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\OrderItem;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\AboutManagementController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\ContactController as PublicContactController;




/*
|--------------------------------------------------------------------------
| 1. Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $latestWorks = Work::latest()->take(10)->get();
    $barbers = Barber::all();

    // --- ส่วนสถิติ ---
    $totalSales = \App\Models\OrderItem::sum('quantity') ?? 0;
    $totalCustomers = Customer::count(); // อันนี้คุณบอกว่าเปลี่ยนแล้ว แสดงว่า Model นี้ถูกต้อง

    // ตรงนี้สำคัญ! "จำนวนหัวลูกค้าที่ตัด" ปกติควรนับจาก 'การจอง' หรือ 'ผลงาน'
    // ลองเปลี่ยนเป็นนับจากตาราง Appointment (ถ้ามี) หรือใช้ $latestWorks รวมทั้งหมด
    $totalStyles = Appointment::where('status', 'completed')->count();
    // ^ ถ้าไม่มีตาราง Appointment ให้ลองใช้ Work::count() แทนไปก่อนครับ

    return view('welcome', compact(
        'latestWorks',
        'barbers',
        'totalSales',
        'totalCustomers',
        'totalStyles'
    ));
})->name('home');

// กลุ่ม Login/Register (ไม่ต้อง Login ก็เข้าได้)
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.post');
    Route::get('/forgot-password', [CustomerAuthController::class, 'showForgot'])->name('forgot');
    Route::get('/forgot-password', [CustomerAuthController::class, 'showForgot'])->name('forgot');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\CustomerPasswordController::class, 'sendLink'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\CustomerPasswordController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\CustomerPasswordController::class, 'reset'])->name('password.store');

    // กลุ่มที่ต้อง Login ก่อนถึงจะเข้าได้ (Protected Routes)
    Route::middleware(['auth:customer'])->group(function () {
        // Logout
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

        // Profile (ชื่อจะเป็น customer.profile อัตโนมัติจาก Prefix ด้านบน)
        Route::get('/profile', [CustomerAuthController::class, 'profile'])->name('profile');

        // Update Profile (เตรียมไว้สำหรับอนาคต)
        Route::post('/profile/update', [CustomerAuthController::class, 'updateProfile'])->name('profile.update');

        // Profile Edit (URL: /customer/profile/edit | Name: customer.profile.edit)
        Route::get('/profile/edit', [CustomerAuthController::class, 'editProfile'])->name('profile.edit');

        // Update Profile (URL: /customer/profile/update | Name: customer.profile.update)
        Route::post('/profile/update', [CustomerAuthController::class, 'updateProfile'])->name('profile.update');
    });
});

// about us management
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about');

// ระบบจองคิว
Route::get('/booking', [BookingController::class, 'index'])->name('book.index');
Route::post('/booking/store', [BookingController::class, 'store'])->name('book.store');
Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');
Route::post('/booking/{id}/slip', [BookingController::class, 'uploadSlip'])->name('booking.slip.upload');
Route::get('/booking/payment', [BookingController::class, 'payment'])->name('booking.payment');
Route::get('/booking/booked-times', [BookingController::class, 'bookedTimes'])->name('booking.bookedTimes');
// ระบบ Shop & Cart
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart-update', [CheckoutController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// ระบบ contact us
// เขียนแบบระบุ Path เต็ม (ไม่ต้องมี use ที่หัวไฟล์)
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');



Route::middleware(['auth:customer'])->group(function () {
    Route::get('/booking-history', [BookingController::class, 'history'])->name('booking.history');
});

/*
|--------------------------------------------------------------------------
| 2. Authentication Routes (เขียนแยกเพื่อเลี่ยง Error laravel/ui)
|--------------------------------------------------------------------------
*/

// --- Login / Logout ---
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('admin.login.submit');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// --- Register ---
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// --- Password Reset ---
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');


// Google Auth Routes
Route::get('auth/google', [CustomerAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [CustomerAuthController::class, 'handleGoogleCallback']);


/*
|--------------------------------------------------------------------------
| 3. Customer Routes
|--------------------------------------------------------------------------
*/
// เปลี่ยนจาก 'auth' เป็น 'auth:customer' เพื่อให้ตรงกับคนที่ล็อกอินเข้ามา
Route::middleware(['auth:customer'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/payment', [CheckoutController::class, 'processPayment'])->name('checkout.processPayment');
    Route::post('/checkout/confirm', [CheckoutController::class, 'finalConfirm'])->name('checkout.finalConfirm');
});

/*
|--------------------------------------------------------------------------
| 4. Admin Section
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');


    //contact us management
    Route::get('/contact', [ContactController::class, 'edit'])->name('contact.edit');
    Route::put('/contact', [ContactController::class, 'update'])->name('contact.update');


    Route::get('/about', [AboutManagementController::class, 'edit'])->name('about.edit');

    // หน้าบันทึกข้อมูล (แก้ตรงนี้!)
    Route::put('/about/update', [AboutManagementController::class, 'update'])->name('about.update');

    // รูทสำหรับลบรูปภาพแกลเลอรีเกี่ยวกับเรา
    Route::delete('/about/image/{id}', [AboutManagementController::class, 'destroyImage'])
        ->name('about.image.destroy');



    // 1. กลุ่ม Appointments (จัดการคิวและ PDF)
    Route::prefix('appointments')->name('appointments.')->group(function () {
        // รายงานรายวัน
        Route::get('/report-pdf', [AdminController::class, 'reportPDF'])->name('reportPDF');

        // ใบเสร็จรายบุคคล
        Route::get('/receipt-pdf/{id}', [AdminController::class, 'receiptPDF'])->name('receiptPDF');

        // รายงานรายเดือน (แก้ไขบรรทัดนี้)
        Route::get('/report-monthly', [AdminController::class, 'reportMonthlyPDF'])->name('reportMonthlyPDF');

        //สรุปทั้งหมด
        Route::get('/analytics/pdf', [AdminController::class, 'analyticsPDF'])->name('analytics.pdf');

        // สถานะการจอง
        Route::patch('/complete/{id}', [AppointmentController::class, 'complete'])->name('complete');
        Route::patch('/{id}/cancel', [AdminController::class, 'cancelAppointment'])->name('cancel');
        // หมายเหตุ: complete_alt ถูกรวมเข้ากับ complete ด้านบนแล้วเพื่อความไม่งง

        Route::patch('/{id}/payment', [AppointmentController::class, 'updatePayment'])->name('payment');
    });

    // 2. Profile Admin
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

    // 3. Services Management
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [AdminController::class, 'manageServices'])->name('index');
        Route::post('/', [AdminController::class, 'storeService'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'editService'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateService'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroyService'])->name('destroy');
    });

    // 4. Works Management
    Route::prefix('works')->name('works.')->group(function () {
        Route::get('/', [AdminController::class, 'manageWorks'])->name('index');
        Route::post('/', [AdminController::class, 'storeWork'])->name('store');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
    });

    // 5. Resources (Products & Barbers)
    Route::resource('products', ProductController::class)->names('products');
    Route::resource('barbers', BarberController::class)->names('barbers');

    // 6. Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::patch('/{id}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
        Route::get('/export-pdf', [OrderController::class, 'exportPDF'])->name('exportPDF');
    });
});
