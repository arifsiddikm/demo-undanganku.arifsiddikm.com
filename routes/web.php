<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TestimonialController;

// PUBLIC
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::get('/preset', [HomeController::class, 'templates'])->name('templates.index');
Route::get('/preset/{slug}/preview', [HomeController::class, 'previewTemplate'])->name('templates.preview');

// AUTH
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class,'showLogin'])->name('login');
    Route::post('/login', [AuthController::class,'login']);
    Route::get('/register', [AuthController::class,'showRegister'])->name('register');
    Route::post('/register', [AuthController::class,'register']);
    Route::get('/forgot-password', [AuthController::class,'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class,'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class,'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class,'resetPassword'])->name('password.update');
});
Route::post('/logout', [AuthController::class,'logout'])->name('logout')->middleware('auth');

// DASHBOARD
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class,'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class,'updateProfile'])->name('profile.update');

    Route::get('/dashboard/invitations', [InvitationController::class,'index'])->name('invitations.index');
    Route::get('/dashboard/invitations/{id}/upgrade', [InvitationController::class,'upgrade'])->name('invitations.upgrade');
    Route::get('/dashboard/invitations/create', [InvitationController::class,'create'])->name('invitations.create');
    Route::post('/dashboard/invitations', [InvitationController::class,'store'])->name('invitations.store');
    Route::delete('/dashboard/invitations/{id}', [InvitationController::class,'destroy'])->name('invitations.destroy');

    Route::get('/dashboard/editor/{id}', [InvitationController::class,'edit'])->name('editor.show');
    Route::post('/dashboard/invitations/{id}/save', [InvitationController::class,'save'])->name('invitations.save');
    Route::post('/dashboard/invitations/{id}/upload', [InvitationController::class,'uploadImage'])->name('invitations.upload');
    Route::post('/dashboard/invitations/{id}/gallery', [InvitationController::class,'uploadGallery'])->name('invitations.gallery');
    Route::post('/dashboard/invitations/{id}/music', [InvitationController::class,'uploadMusic'])->name('invitations.music');
    Route::delete('/dashboard/photos/{id}', [InvitationController::class,'deletePhoto'])->name('photos.delete');
    Route::get('/dashboard/invitations/{id}/preview', [InvitationController::class,'preview'])->name('invitation.preview');
    Route::get('/dashboard/check-slug', [InvitationController::class,'checkSlug'])->name('invitations.checkSlug');

    Route::post('/dashboard/guests', [InvitationController::class,'addGuest'])->name('guests.store');
    Route::delete('/dashboard/guests/{id}', [InvitationController::class,'deleteGuest'])->name('guests.delete');
    Route::post('/dashboard/gifts', [InvitationController::class,'addGift'])->name('gifts.store');
    Route::delete('/dashboard/gifts/{id}', [InvitationController::class,'deleteGift'])->name('gifts.delete');

    Route::get('/dashboard/orders', [OrderController::class,'index'])->name('orders.index');
    Route::post('/dashboard/orders', [PaymentController::class,'storeTransfer'])->name('orders.store');
    Route::get('/dashboard/orders/{id}', [OrderController::class,'show'])->name('orders.show');
    Route::post('/dashboard/orders/{id}/upload-proof', [PaymentController::class,'uploadTransferProof'])->name('orders.uploadProof');

    Route::post('/dashboard/testimonial', [TestimonialController::class,'store'])->name('testimonials.store.user');

    Route::get('/checkout/{slug}', [PaymentController::class,'checkout'])->name('checkout');
    Route::get('/checkout/{slug}/{invitation_id}', [PaymentController::class,'checkoutForInvitation'])->name('checkout.invitation');
    Route::post('/payment/get-snap-token', [PaymentController::class,'getSnapToken'])->name('payment.getSnapToken');
    Route::get('/payment/finish', [PaymentController::class,'finishRedirect'])->name('payment.finish');
});

// MIDTRANS CALLBACK
Route::post('/payment/midtrans/notification', [PaymentController::class,'notification'])
    ->name('payment.notification')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

// ADMIN
Route::prefix('webmin')->name('admin.')->middleware(['auth','admin'])->group(function () {
    Route::get('/', [AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class,'users'])->name('users');
    Route::post('/users/{id}/toggle', [AdminController::class,'toggleUser'])->name('users.toggle');
    Route::get('/orders', [AdminController::class,'orders'])->name('orders');
    Route::get('/orders/{id}', [AdminController::class,'showOrder'])->name('orders.show');
    Route::post('/orders/{id}/confirm', [AdminController::class,'confirmOrder'])->name('orders.confirm');
    Route::get('/invitations', [AdminController::class,'invitations'])->name('invitations');
    Route::get('/invitations/{id}', [AdminController::class,'showInvitation'])->name('invitations.show');
    Route::get('/templates', [AdminController::class,'templates'])->name('templates');
    Route::get('/templates/create', [AdminController::class,'createTemplate'])->name('templates.create');
    Route::post('/templates', [AdminController::class,'storeTemplate'])->name('templates.store');
    Route::get('/templates/{id}/edit', [AdminController::class,'editTemplate'])->name('templates.edit');
    Route::put('/templates/{id}', [AdminController::class,'updateTemplate'])->name('templates.update');
    Route::delete('/templates/{id}', [AdminController::class,'deleteTemplate'])->name('templates.delete');
    Route::get('/bank-accounts', [AdminController::class,'bankAccounts'])->name('bank-accounts');
    Route::post('/bank-accounts', [AdminController::class,'storeBankAccount'])->name('bank-accounts.store');
    Route::put('/bank-accounts/{id}', [AdminController::class,'updateBankAccount'])->name('bank-accounts.update');
    Route::delete('/bank-accounts/{id}', [AdminController::class,'deleteBankAccount'])->name('bank-accounts.delete');
    Route::get('/music', [AdminController::class,'presetMusics'])->name('music');
    Route::post('/music', [AdminController::class,'storePresetMusic'])->name('music.store');
    Route::post('/music/upload', [AdminController::class,'uploadMusic'])->name('music.upload');
    Route::delete('/music/{id}', [AdminController::class,'deletePresetMusic'])->name('music.delete');
    Route::get('/portfolios', [AdminController::class,'portfolios'])->name('portfolios');
    Route::post('/portfolios', [AdminController::class,'storePortfolio'])->name('portfolios.store');
    Route::post('/portfolios/{id}/url', [AdminController::class,'updatePortfolioUrl'])->name('portfolios.updateUrl');
    Route::post('/portfolios/{id}/update', [AdminController::class,'updatePortfolio'])->name('portfolios.update');
    Route::put('/portfolios/{id}', [AdminController::class,'updatePortfolioFull'])->name('portfolios.update_full');
    Route::delete('/portfolios/{id}', [AdminController::class,'deletePortfolio'])->name('portfolios.delete');
    Route::get('/faqs', [AdminController::class,'faqs'])->name('faqs');
    Route::post('/faqs', [AdminController::class,'storeFaq'])->name('faqs.store');
    Route::put('/faqs/{id}', [AdminController::class,'updateFaq'])->name('faqs.update');
    Route::delete('/faqs/{id}', [AdminController::class,'deleteFaq'])->name('faqs.delete');
    Route::get('/testimonials', [AdminController::class,'testimonials'])->name('testimonials');
    Route::post('/testimonials', [AdminController::class,'storeTestimonial'])->name('testimonials.store');
    Route::delete('/testimonials/{id}', [AdminController::class,'deleteTestimonial'])->name('testimonials.delete');
    Route::post('/user-testimonials/{id}/approve', [AdminController::class,'approveUserTestimonial'])->name('testimonials.approve');
    Route::post('/user-testimonials/{id}/reject', [AdminController::class,'rejectUserTestimonial'])->name('testimonials.reject');
});
Route::get('/webmin/login', [AuthController::class,'showLogin'])->name('admin.login')->middleware('guest');
Route::post('/webmin/login', [AuthController::class,'login'])->middleware('guest');

// PUBLIC INVITATION — harus paling bawah
$slugPattern = '^(?!dashboard|login|register|logout|profile|checkout|payment|preset|portfolio|webmin|favicon|storage|api)[a-z0-9][a-z0-9\-]{1,60}$';
Route::get('/{slug}', [InvitationController::class,'show'])->name('invitation.show')->where('slug',$slugPattern);
Route::post('/{slug}/rsvp', [InvitationController::class,'submitRsvp'])->name('invitation.rsvp')->where('slug',$slugPattern)->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
Route::post('/{slug}/wish', [InvitationController::class,'submitWish'])->name('invitation.wish')->where('slug',$slugPattern)->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
