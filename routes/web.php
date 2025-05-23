<?php


use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientOrders;
use App\Http\Controllers\DriverAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\TwoFactorController;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DriverController; //JULIEN

Route::get('/', function () {
    return view('WelcomePage');
})->name('welcome');


Route::get('driver/login', [DriverAuthController::class, 'showLoginForm'])->name('driver.login');
Route::post('driver/login', [DriverAuthController::class, 'login'])->name('driver.login.submit');

Route::get('driver/signup', [DriverAuthController::class, 'showSignUpForm'])->name('driver.signup');
Route::post('driver/signup', [DriverAuthController::class, 'signUp'])->name('driver.signup.submit');

Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

//Route::get('admin/signup', [AdminAuthController::class, 'showSignUpForm'])->name('admin.signup');
//Route::post('admin/signup', [AdminAuthController::class, 'signUp'])->name('admin.signup.submit');

/*----------------------------------------- Raed--------------------------------------------*/
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/list_drivers', [AdminController::class, 'listDrivers'])->name('admin.driver');
    Route::get('admin/add_drivers', [AdminController::class, 'viewForm'])->name('admin.addDriver');
    Route::get('admin/driver{id}', [AdminController::class, 'showDrivers'])->name('drivers_profile');
    Route::post('admin/store-driver', [AdminAuthController::class, 'storeDriver'])->name('admin.storeDriver');
    Route::get('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::post('admin/save_drivers', [AdminController::class, 'addDriver'])->name('admin.save');
    Route::post('admin/count_d',[AdminController::class, 'countAvailableDrivers'])->name('admin.count_drivers');
    Route::get('admin/orders-by-day', [AdminController::class, 'ordersByDay'])->name('admin.ordersByDay');
    Route::post('/driver/{id}/accept', [AdminController::class, 'acceptDriver'])->name('admin.acceptDriver');
    Route::post('/driver/{id}/deny', [AdminController::class, 'denyDriver'])->name('admin.denyDriver');

    Route::get('admin/driver{id}', [AdminController::class, 'showDriver'])->name('admin.viewDriver');
    Route::delete('admin/delete_driver/{id}',[AdminController::class, 'destroyDriver'])->name('admin.deleteDriver');
    Route::get('admin/edit_driver',[AdminController::class, 'editDriver'])->name('admin.editDriver');
    Route::put('admin/update_driver/{id}',[AdminController::class, 'updateDriver'])->name('admin.updateDriver');


    Route::get('admin/orders', [AdminController::class, 'viewOrders'])->name('admin.showOrders');
    Route::get('/admin/reports/filter', [AdminController::class, 'filterReports'])->name('admin.reports.filter');

});


Route::get('client/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
Route::get('login', [ClientAuthController::class, 'showLoginForm'])->name('login'); // fallback

Route::post('client/login', [ClientAuthController::class, 'login'])->name('client.login.submit');

// Show the sign-up page for clients
Route::get('client/signup', [ClientAuthController::class, 'showSignUpForm'])->name('client.signup');
Route::post('client/signup', [ClientAuthController::class, 'signUp'])->name('client.signup.submit');

Route::middleware(['auth', 'TwoFactor'])->group(function () {
    Route::get('client/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
});


Route::get('/client/verify', [ClientAuthController::class, 'showOtpForm'])->name('verify.otp');
Route::post('/client/verify', [ClientAuthController::class, 'verifyOtp'])->name('verify.otp.submit');

Route::get('/driver/verify', [DriverAuthController::class, 'showDriverOtpForm'])->name('driver.verify.otp');
Route::post('/driver/verify', [DriverAuthController::class, 'verifyDriverOtp'])->name('driver.verify.otp.submit');

/*----------------------------------------- ADMIN ISMAIL --------------------------------------------*/
Route::get('admin/orders', [AdminController::class, 'listOrders'])->name('admin.showOrders');
Route::get('admin/driver{id}', [AdminController::class, 'showDriver'])->name('admin.viewDriver');
Route::get('admin/orders/{id}', [adminController::class, 'OrderDetails'])->name('admin.showOrderDetails');


Route::delete('admin/delete_driver/{id}',[AdminController::class, 'destroyDriver'])->name('admin.deleteDriver');
Route::get('admin/edit_driver/{id}', [AdminController::class, 'editDriver'])->name('admin.editDriver');


Route::get('admin/loyalty', [AdminLoyaltyController::class, 'index'])->name('admin.loyalty');
Route::post('admin/loyalty', [AdminLoyaltyController::class, 'store'])->name('admin.loyalty.store');


/*-----------------------------------------DRIVER JULIEN--------------------------------------------*/
use App\Http\Controllers\DriverMenuController;

Route::middleware(['is_driver'])->group(function () {
    Route::get('driver/driverMenu', [DriverMenuController::class, 'index'])->name('driver.Menu');
    Route::get('driver/myProfile', [DriverMenuController::class, 'myProfile'])->name('driver.myProfile');
    Route::get('driver/pendingOrders', [DriverMenuController::class, 'pendingOrders'])->name('driver.pendingOrders');
    Route::get('driver/inProcessOrders', [DriverMenuController::class, 'inProcessOrders'])->name('driver.inProcessOrders');
    Route::get('driver/completedOrders', [DriverMenuController::class, 'completedOrders'])->name('driver.completedOrders');
    Route::get('driver/cancelledOrders', [DriverMenuController::class, 'cancelledOrders'])->name('driver.cancelledOrders');
    Route::get('driver/manageAvailability', [DriverMenuController::class, 'manageAvailability'])->name('driver.manageAvailability');
    Route::get('driver/AreaAndPricing', [DriverMenuController::class, 'AreaAndPricing'])->name('driver.AreaAndPricing');
    Route::get('driver/viewOrderDetails/{id}', [DriverMenuController::class, 'OrderDetails'])->name('driver.viewOrderDetails');
    Route::get('driver/myCalendar', [DriverMenuController::class, 'myCalendar'])->name('driver.myCalendar');
    Route::get('driver/myReviews', [DriverMenuController::class, 'myReviews'])->name('driver.myReviews');
    Route::get('driver/myEarnings', [DriverMenuController::class, 'myEarnings'])->name('driver.myEarnings');
    Route::post('driver/storeFCMtoken', [DriverMenuController::class, 'storeFCMtoken'])->name('storeFCMtoken');


    Route::put('driver/updateDriverProfile', [DriverController::class, 'updateDriverProfile'])->name('driver.updateDriverProfile');
    Route::put('driver/updateDriverPassword', [DriverController::class, 'updateDriverPassword'])->name('driver.updateDriverPassword');
    Route::put('driver/updateAreaAndPricing', [DriverController::class, 'updateAreaAndPricing'])->name('driver.updateAreaAndPricing');
    Route::put('driver/updateOrderStatusByDriver', [DriverController::class, 'updateOrderStatusByDriver'])->name('driver.updateOrderStatusByDriver');
    Route::put('driver/updateOrderDeliveryDate', [DriverController::class, 'updateOrderDeliveryDate'])->name('driver.updateOrderDeliveryDate');
    Route::post('driver/updateDriverAvailability', [DriverController::class, 'updateDriverAvailability'])->name('driver.updateDriverAvailability');
    Route::put('driver/acceptPayment', [DriverController::class, 'acceptPayment'])->name('driver.acceptPayment');
});

Route::get('driver/logout', [DriverController::class, 'driverlogout'])->name('driver.logout');
/*--------------------------------------------------------------------------------------------------*/

Route::get('client/request_order',[ClientController::class,'client_request_order'])->name("client_request_order");
Route::post('store_order',[ClientController::class,'store_order'])->name('store_order');
Route::get('store_time',[ClientController::class,'find_time'])->name('find_time');
Route::get('client/calculate_distance/{id}',[ClientController::class,'calculateDistance'])->name('calculate_distance');
Route::get('client/error',[ClientController::class,'client_error'])->name('client_error');
// Route for the chats page
Route::get('chats', [ChatsController::class, 'index'])->name('chats');
// Route for sending messages
Route::post('/send-message', [ChatsController::class, 'sendMessage'])->name('send-message');
// Route for getting chats history
Route::get('communication-history', [ChatsController::class, 'getChatHistory'])->name('communication-history');
// Route for uploading communication photos
Route::post('upload-communication-photo', [ChatsController::class, 'uploadImage'])->name('upload-communication-photo');
// Route for getting new messages
Route::get('get-new-messages/{user_id?}', [ChatsController::class, 'getNewMessages'])->name('get-new-messages');
Route::post('orders/{id}/assign_driver', [OrderController::class, 'assignDriverManually'])->name('orders.assignDriver');
Route::post('orders/{id}/auto_assign_driver', [OrderController::class, 'autoAssignDriver'])->name('orders.autoAssignDriver');
Route::get('orders/{id}/assign_driver', [OrderController::class, 'showAssignDriverForm'])->name('orders.showAssignDriverForm');
Route::get('stripe', [PaymentController::class, 'index'])->name('stripe.index');
Route::post('stripe/create-charge', [PaymentController::class, 'createCharge'])->name('stripe.create-charge');
//Route::get('/select-currency', [PaymentController::class, 'showForm'])->name('currency.form');
//Route::post('/select-currency', [PaymentController::class, 'convertCurrency'])->name('currency.convert');
/*Route::post('/payment/calculate/{orderId}', [PaymentController::class, 'calculateAndStorePayment'])
    ->name('payment.calculate');
Route::get('/payment/calculate/{orderId}', [PaymentController::class, 'showCurrencyForm'])
    ->name('currency.form');
*/
Route::match(['get', 'post'], '/payment/calculate/{orderId}', [PaymentController::class, 'currencyForm'])->name('payment.form');
Route::get('client/listOrders',[ClientOrders::class, 'listClientOrders'])->name('clientOrders');
Route::get('client/view-reviews/{id}',[ClientOrders::class, 'showReviews'])->name('clientOrders.viewReviews');
Route::post('client/writeReview/{id}',[ClientOrders::class, 'writeReview'])->name('clientOrders.writeReview');
Route::get('client/calendar/{id}',[ClientOrders::class, 'myCalendarr'])->name('clientOrders.calendar');
Route::get('client/view-profile/{id}',[OrderController::class, 'showDriverProfile'])->name('clientOrders.viewProfile');
Route::delete('orders/delete/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');


Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [SocialiteController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [SocialiteController::class, 'handleFacebookCallback']);


Route::get('/auth/github', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/github/callback', [SocialiteController::class, 'handleGitHubCallback']);

//Raed trying

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('admin/reports', [AdminReportController::class, 'reports'])->name('admin.reports');

});
Route::middleware(['is_client', 'TwoFactor'])->group(function () {
    Route::get('client/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
    //lynn add ur routes here when you finish
});




// Route for the chats page
Route::get('chats', [ChatsController::class, 'index'])->name('chats');

// Route for sending messages
Route::post('/send-message', [ChatsController::class, 'sendMessage'])->name('send-message');


// Route for getting chats history
Route::get('communication-history', [ChatsController::class, 'getChatHistory'])->name('communication-history');

// Route for uploading communication photos
Route::post('upload-communication-photo', [ChatsController::class, 'uploadImage'])->name('upload-communication-photo');

// Route for getting new messages
Route::get('get-new-messages/{user_id?}', [ChatsController::class, 'getNewMessages'])->name('get-new-messages');
