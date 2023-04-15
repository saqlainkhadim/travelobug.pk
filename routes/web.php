<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::get('enable-debugger', 'HomeController@activateDebugger');

Route::match(array('GET', 'POST'), 'create-users-wallet', 'HomeController@walletUser');


//cron job

Route::get('cron/ical-synchronization', 'CronController@iCalendarSynchronization');

//user can view it anytime with or without logged in
Route::group(['middleware' => ['locale']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('search/result', 'SearchController@searchResult');
    Route::get('search', 'SearchController@index')->name('property.search');
    Route::match(array('GET', 'POST'), 'properties/{slug}', 'PropertyController@single')->name('property.single');
    Route::match(array('GET', 'POST'), 'property/get-price', 'PropertyController@getPrice');
    Route::get('set-slug/', 'PropertyController@set_slug');
    Route::get('signup', 'LoginController@signup');
    Route::post('/checkUser/check', 'LoginController@check')->name('checkUser.check');

    Route::match(['GET', 'POST'], 'activities/{slug}', 'ActivityController@single')->name('activity.single');
    Route::match(['GET', 'POST'], 'activity/get-price', 'ActivityController@getPrice');
    Route::get('activity/set-slug', 'ActivityController@set_slug');
    Route::post('activities/search/result', 'SearchController@searchResult');
    Route::get('activities/search', 'SearchController@index')->name('activity.search');
});

//Auth::routes();

Route::post('set_session', 'HomeController@setSession');

// admin routes
require __DIR__ . DIRECTORY_SEPARATOR . 'admin.php';

//only can view if user is not logged in if they are logged in then they will be redirect to dashboard
Route::group(['middleware' => ['no_auth:users', 'locale']], function () {
    Route::get('login', 'LoginController@index');
    Route::get('auth/login', function () {
        return Redirect::to('login');
    });

    Route::get('googleLogin', 'LoginController@googleLogin')->middleware('social_login:google_login');
    Route::get('facebookLogin', 'LoginController@facebookLogin')->middleware('social_login:facebook_login');
    Route::get('register', 'HomeController@register');
    Route::match(array('GET', 'POST'), 'forgot_password', 'LoginController@forgotPassword');
    Route::post('create', 'UserController@create');
    Route::post('authenticate', 'LoginController@authenticate');
    Route::get('users/reset_password/{secret?}', 'LoginController@resetPassword');
    Route::post('users/reset_password', 'LoginController@resetPassword');
});

Route::get('googleAuthenticate', 'LoginController@googleAuthenticate');
Route::get('facebookAuthenticate', 'LoginController@facebookAuthenticate');

//only can view if user is logged in
Route::group(['middleware' => ['guest:users', 'locale']], function () {
    Route::get('dashboard', 'UserController@dashboard');
    Route::match(array('GET', 'POST'), 'users/profile', 'UserController@profile');
    Route::match(array('GET', 'POST'), 'users/profile/media', 'UserController@media');

    // User verification
    Route::get('users/edit-verification', 'UserController@verification');
    Route::get('users/confirm_email/{code?}', 'UserController@confirmEmail');
    Route::get('users/new_email_confirm', 'UserController@newConfirmEmail');

    Route::get('facebookLoginVerification', 'UserController@facebookLoginVerification');
    Route::get('facebookConnect/{id}', 'UserController@facebookConnect');
    Route::get('facebookDisconnect', 'UserController@facebookDisconnectVerification');

    Route::get('googleLoginVerification', 'UserController@googleLoginVerification');
    Route::get('googleConnect/{id}', 'UserController@googleConnect');
    Route::get('googleDisconnect', 'UserController@googleDisconnect');
    // Route::get('googleAuthenticate', 'LoginController@googleAuthenticate');

    Route::get('users/show/{id}', 'UserController@show');
    Route::match(array('GET', 'POST'), 'users/reviews', 'UserController@reviews');
    Route::match(array('GET', 'POST'), 'users/reviews_by_you', 'UserController@reviewsByYou');
    Route::match(['get', 'post'], 'reviews/edit/{id}', 'UserController@editReviews');
    Route::match(['get', 'post'], 'reviews/details', 'UserController@reviewDetails');

    Route::match(array('GET', 'POST'), 'properties', 'PropertyController@userProperties');
    Route::match(array('GET', 'POST'), 'property/create', 'PropertyController@create')->name('user.property.create');
    Route::match(array('GET', 'POST'), 'listing/{id}/photo_message', 'PropertyController@photoMessage')->middleware(['checkUserRoutesPermissions']);
    Route::match(array('GET', 'POST'), 'listing/{id}/photo_delete', 'PropertyController@photoDelete')->middleware(['checkUserRoutesPermissions']);

    Route::match(array('POST'), 'listing/photo/make_default_photo', 'PropertyController@makeDefaultPhoto');

    Route::match(array('POST'), 'listing/photo/make_photo_serial', 'PropertyController@makePhotoSerial');

    Route::match(array('GET', 'POST'), 'listing/update_status', 'PropertyController@updateStatus');
    Route::match(array('GET', 'POST'), 'listing/{id}/{step}', 'PropertyController@listing')->where(['id' => '[0-9]+', 'page' => 'basics|description|location|amenities|photos|pricing|calendar|details|booking']);

    // Favourites routes
    Route::get('user/favourite', 'PropertyController@userBookmark');
    Route::post('add-edit-book-mark', 'PropertyController@addEditBookMark');

    //#### Activity routes
    Route::match(['GET', 'POST'], 'activities', 'ActivityController@userActivities');
    Route::match(['GET', 'POST'], 'activity/create', 'ActivityController@create')->name('user.activity.add');
    Route::match(['POST'], 'activity/listing/photo/make_default_photo', 'ActivityController@makeDefaultPhoto');
    Route::match(['POST'], 'activity/listing/photo/make_photo_serial', 'ActivityController@makePhotoSerial');
    Route::match(['GET', 'POST'], 'activity/listing/{id}/photo_message', 'ActivityController@photoMessage')->middleware(['checkUserRoutesPermissions']);
    Route::match(['GET', 'POST'], 'activity/listing/{id}/photo_delete', 'ActivityController@photoDelete');
    Route::match(['GET', 'POST'], 'activity/listing/update_status', 'ActivityController@updateStatus');
    Route::match(['GET', 'POST'], 'activity/listing/{id}/{step}', 'ActivityController@listing')
        ->where(['id' => '[0-9]+', 'page' => 'basics|description|location|amenities|photos|pricing|calendar|details|booking'])
        ->name('user.activity.listing');
    Route::get('activity/user/favourite', 'ActivityController@userBookmark');
    Route::post('activity/add-edit-book-mark', 'ActivityController@addEditBookMark');


    Route::post('ajax-calender/{id}', 'CalendarController@calenderJson');
    Route::post('ajax-calender-price/{id}', 'CalendarController@calenderPriceSet');
    //iCalendar routes start
    Route::post('ajax-icalender-import/{id}', 'CalendarController@icalendarImport');
    Route::get('icalendar/synchronization/{id}', 'CalendarController@icalendarSynchronization');
    //iCalendar routes end
    Route::post('currency-symbol', 'PropertyController@currencySymbol');
    Route::match(['get', 'post'], 'payments/book/{id?}', 'PaymentController@index');
    Route::post('payments/create_booking', 'PaymentController@createBooking');
    Route::get('payments/success', 'PaymentController@success');
    Route::get('payments/cancel', 'PaymentController@cancel');
    Route::get('payments/stripe', 'PaymentController@stripePayment');
    Route::post('payments/stripe-request', 'PaymentController@stripeRequest');
    // Easypaisa
    Route::get('payments/easypaisa', 'PaymentController@easypaisaPayment');
    Route::post('payments/easypaisa', 'PaymentController@easypaisaDoPayment');    

    


    Route::get('payments/jazzcash', 'PaymentController@jazzcashPayment');
    Route::post('payments/jazzcash-response', 'PaymentController@jazzcashPaymentResponse')->middleware('JazzcashCsrfTokenConversion');
    Route::post('payments/easypaisa-request', 'PaymentController@easypaisaRequest');
    Route::get('payments/easypaisa-request', 'PaymentController@easypaisaRequest');
    Route::get('payments/easypaisa-confirm', 'PaymentController@easypaisaConfirm');

    Route::match(['get', 'post'], 'payments/bank-payment', 'PaymentController@bankPayment');
    Route::get('booking/{id}', 'BookingController@index')->where('id', '[0-9]+');
    Route::get('booking_payment/{id}', 'BookingController@requestPayment')->where('id', '[0-9]+');
    Route::get('booking/requested', 'BookingController@requested');
    Route::get('booking/itinerary_friends', 'BookingController@requested');
    Route::post('booking/accept/{id}', 'BookingController@accept');
    Route::post('booking/decline/{id}', 'BookingController@decline');
    Route::get('booking/expire/{id}', 'BookingController@expire');
    Route::match(['get', 'post'], 'my-bookings', 'BookingController@myBookings');
    Route::post('booking/host_cancel', 'BookingController@hostCancel');
    Route::match(['get', 'post'], 'trips/active', 'TripsController@myTrips');
    Route::get('booking/receipt', 'TripsController@receipt');
    Route::post('trips/guest_cancel', 'TripsController@guestCancel');

    // Messaging
    Route::match(['get', 'post'], 'inbox', 'InboxController@index');
    Route::post('messaging/booking/', 'InboxController@message');
    Route::post('messaging/reply/', 'InboxController@messageReply');

    Route::match(['get', 'post'], 'users/account-preferences', 'UserController@accountPreferences');
    Route::get('users/account_delete/{id}', 'UserController@accountDelete');
    Route::get('users/account_default/{id}', 'UserController@accountDefault');
    Route::get('users/transaction-history', 'UserController@transactionHistory');
    Route::post('users/account_transaction_history', 'UserController@getCompletedTransaction');
    // for customer payout settings
    Route::match(['GET', 'POST'], 'users/payout', 'PayoutController@index');
    Route::match(['GET', 'POST'], 'users/payout/setting', 'PayoutController@setting');
    Route::match(['GET', 'POST'], 'users/payout/edit-payout/', 'PayoutController@edit');
    Route::match(['GET', 'POST'], 'users/payout/delete-payout/{id}', 'PayoutController@delete');

    // for payout request
    Route::match(['GET', 'POST'], 'users/payout-list', 'PayoutController@payoutList');
    Route::match(['GET', 'POST'], 'users/payout/success', 'PayoutController@success');

    Route::match(['get', 'post'], 'users/security', 'UserController@security');

    Route::get('users/notification', 'UserController@notification')->name('notifications');
    Route::get('users/notification/read/{id}', 'UserController@notificationRead')->name('user.notification.read');
    Route::get('users/notification/delete/{id?}', 'UserController@notificationDelete')->name('user.notification.delete');
    Route::get('logout', function () {
        Auth::logout();
        Session::flush();
        return Redirect::to('login');
    });
});

Route::post('home/address/search', 'HomeController@homeAddressSearch')->name('home-address-search');
Route::post('address/search', 'HomeController@addressSearch')->name('address-search');

//for exporting iCalendar
Route::get('icalender/export/{id}', 'CalendarController@icalendarExport');
Route::post('duplicate-phone-number-check', 'UserController@duplicatePhoneNumberCheck');
Route::post('duplicate-phone-number-check-for-existing-customer', 'UserController@duplicatePhoneNumberCheckForExistingCustomer');
Route::get('contact', 'HomeController@contactPage');
Route::post('contact/form', 'HomeController@contactForm');
Route::get('{name}', 'HomeController@staticPages');
