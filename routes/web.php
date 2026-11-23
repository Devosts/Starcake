<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// ============================================================================
// ADMIN
// ============================================================================
Route::prefix('admin')->name('admin.')->middleware('guest_admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
});

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', AdminDashboardController::class)->name('dashboard');

    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::get('products/{product}', [AdminProductController::class, 'show'])->name('products.show');

    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Live chat with customers
    Route::get('pesan', [AdminChatController::class, 'index'])->name('chat.index');
    Route::get('pesan/{conversation}', [AdminChatController::class, 'show'])->name('chat.show');
    Route::post('pesan/{conversation}/kirim', [AdminChatController::class, 'send'])->middleware('throttle:60,1')->name('chat.send');
    Route::post('pesan/{conversation}/baca', [AdminChatController::class, 'read'])->name('chat.read');

    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}', [AdminReviewController::class, 'updateStatus'])->name('reviews.update-status');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('settings', [AdminSettingController::class, '__invoke'])->name('settings.index');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    Route::get('profile', [AdminProfileController::class, 'show'])->name('profile');
    Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

// Redirect bare /admin to login
Route::get('admin', function () {
    return redirect()->route('admin.login');
});

// ============================================================================
// PUBLIC
// ============================================================================
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/menu', [FrontendController::class, 'index'])->name('products.index');
Route::get('/search', [FrontendController::class, 'index'])->name('search');
Route::get('/kategori/{slug}', [FrontendController::class, 'category'])->name('category.show');
Route::get('/produk/{slug}', [FrontendController::class, 'show'])->name('product.show');

Route::post('/produk/{slug}/review', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('product.review');

// Cart & Checkout (guest-friendly: session-based cart, optional login)
Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
Route::post('/keranjang/tambah/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/hapus/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/keranjang/kosongkan', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/keranjang/jumlah', [CartController::class, 'count'])->name('cart.count');

// Checkout (guest + logged in both supported)
Route::match(['GET', 'POST'], '/checkout', CheckoutController::class)->name('checkout');
Route::get('/checkout/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Order tracking
Route::get('/tracking', [OrderTrackingController::class, '__invoke'])->name('tracking');
Route::get('/tracking/{order}', [OrderTrackingController::class, '__invoke'])->name('tracking.number');

// Customer dashboard (after login/register)
Route::get('/dashboard', [FrontendController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

// Customer profile
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

// Static pages
Route::get('/tentang', [FrontendController::class, 'about'])->name('about');
Route::get('/kontak', ContactController::class)->name('contact');

// Live chat (embedded on the contact page, requires a Star Cake account)
Route::middleware('auth')->group(function () {
    Route::post('/kontak/chat/kirim', [ChatController::class, 'send'])->middleware('throttle:60,1')->name('chat.send');
    Route::post('/kontak/chat/baca', [ChatController::class, 'read'])->name('chat.read');
});

require __DIR__.'/auth.php';
