<?php

//only can view if admin is logged in

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['guest:admin']], function () {
    Route::get('/', function () {
        return Redirect::to('admin/dashboard');
    });

    Route::match(array('GET', 'POST'), 'profile', 'AdminController@profile');
    Route::get('logout', 'AdminController@logout');
    Route::get('dashboard', 'DashboardController@index');
    Route::get('customers', 'CustomerController@index')->middleware(['permission:customers']);
    Route::get('verify-customer/{id}', 'CustomerController@verify')->middleware(['permission:customers']);
    Route::get('customers/customer_search', 'CustomerController@searchCustomer')->middleware(['permission:customers']);
    Route::post('add-ajax-customer', 'CustomerController@ajaxCustomerAdd')->middleware(['permission:add_customer']);
    Route::match(array('GET', 'POST'), 'add-customer', 'CustomerController@add')->middleware(['permission:add_customer']);

    Route::group(['middleware' => 'permission:edit_customer'], function () {
        Route::match(array('GET', 'POST'), 'edit-customer/{id}', 'CustomerController@update');
        Route::get('customer/properties/{id}', 'CustomerController@customerProperties');
        Route::get('customer/bookings/{id}', 'CustomerController@customerBookings');
        Route::post('customer/bookings/property_search', 'BookingsController@searchProperty');
        Route::get('customer/payouts/{id}', 'CustomerController@customerPayouts');
        Route::get('customer/payment-methods/{id}', 'CustomerController@paymentMethods');
        Route::get('customer/wallet/{id}', 'CustomerController@customerWallet');

        Route::get('customer/properties/{id}/property_list_csv', 'PropertiesController@propertyCsv');
        Route::get('customer/properties/{id}/property_list_pdf', 'PropertiesController@propertyPdf');

        Route::get('customer/bookings/{id}/booking_list_csv', 'BookingsController@bookingCsv');
        Route::get('customer/bookings/{id}/booking_list_pdf', 'BookingsController@bookingPdf');

        Route::get('customer/payouts/{id}/payouts_list_pdf', 'PayoutsController@payoutsPdf');
        Route::get('customer/payouts/{id}/payouts_list_csv', 'PayoutsController@payoutsCsv');

        Route::get('customer/customer_list_csv', 'CustomerController@customerCsv');
        Route::get('customer/customer_list_pdf', 'CustomerController@customerPdf');
    });

    Route::group(['middleware' => 'permission:manage_messages'], function () {
        Route::get('messages', 'AdminController@customerMessage');
        Route::match(array('GET', 'POST'), 'delete-message/{id}', 'AdminController@deleteMessage');
        Route::match(array('GET', 'POST'), 'send-message-email/{id}', 'AdminController@sendEmail');
        Route::match(['get', 'post'], 'upload_image', 'AdminController@uploadImage')->name('upload');
        Route::get('messaging/host/{id}', 'AdminController@hostMessage');
        Route::post('reply/{id}', 'AdminController@reply');
    });

    Route::get('properties/add-requests', 'PropertiesController@addRequests')->middleware(['permission:properties']);
    Route::get('listing-property/{id}/approve', 'PropertiesController@requestApprove')->middleware(['permission:properties']);
    Route::get('listing-property/{id}/reject', 'PropertiesController@requestReject')->middleware(['permission:properties']);
    Route::get('properties', 'PropertiesController@index')->middleware(['permission:properties']);
    Route::match(array('GET', 'POST'), 'add-properties', 'PropertiesController@add')->middleware(['permission:add_properties']);
    Route::get('properties/property_list_csv', 'PropertiesController@propertyCsv');
    Route::get('properties/property_list_pdf', 'PropertiesController@propertyPdf');

    Route::group(['middleware' => 'permission:edit_properties'], function () {
        Route::match(array('GET', 'POST'), 'listing/{id}/photo_message', 'PropertiesController@photoMessage');
        Route::match(array('GET', 'POST'), 'listing/{id}/photo_delete', 'PropertiesController@photoDelete');
        Route::match(array('GET', 'POST'), 'listing/{id}/update_status', 'PropertiesController@update_status');
        Route::match(array('POST'), 'listing/photo/make_default_photo', 'PropertiesController@makeDefaultPhoto');
        Route::match(array('POST'), 'listing/photo/make_photo_serial', 'PropertiesController@makePhotoSerial');
        Route::match(array('GET', 'POST'), 'listing/{id}/{step}', 'PropertiesController@listing')->where(['id' => '[0-9]+', 'page' => 'basics|description|location|amenities|photos|pricing|calendar|details|booking']);
    });

    Route::post('ajax-calender/{id}', 'CalendarController@calenderJson');
    Route::post('ajax-calender-price/{id}', 'CalendarController@calenderPriceSet');
    //iCalender routes for admin
    Route::post('ajax-icalender-import/{id}', 'CalendarController@icalendarImport');
    Route::get('icalendar/synchronization/{id}', 'CalendarController@icalendarSynchronization');
    //iCalender routes end
    Route::match(array('GET', 'POST'), 'edit_property/{id}', 'PropertiesController@update')->middleware(['permission:edit_properties']);
    Route::get('delete-property/{id}', 'PropertiesController@delete')->middleware(['permission:delete_property']);

    // bookings
    Route::get('bookings-property', 'BookingsController@index')->middleware(['permission:manage_bookings']);
    Route::get('bookings-property/property_search', 'BookingsController@searchProperty')->middleware(['permission:manage_bookings']);
    Route::get('bookings-property/customer_search', 'BookingsController@searchCustomer')->middleware(['permission:manage_bookings']);
    //booking details
    Route::get('bookings-property/detail/{id}', 'BookingsController@details')->middleware(['permission:manage_bookings']);
    Route::get('bookings-property/edit/{req}/{id}', 'BookingsController@updateBookingStatus')->middleware(['permission:manage_bookings']);
    Route::post('bookings-property/pay', 'BookingsController@pay')->middleware(['permission:manage_bookings']);
    // bookings
    Route::get('bookings-activity', 'BookingsController@indexActivity')->middleware(['permission:manage_bookings']);
    Route::get('bookings-activity/activity_search', 'BookingsController@searchActivity')->middleware(['permission:manage_bookings']);
    Route::get('bookings-activity/customer_search', 'BookingsController@searchCustomer')->middleware(['permission:manage_bookings']);
    //booking details
    Route::get('bookings-activity/detail/{id}', 'BookingsController@detailsActivity')->middleware(['permission:manage_bookings']);
    Route::get('bookings-activity/edit/{req}/{id}', 'BookingsController@updateBookingStatus')->middleware(['permission:manage_bookings']);
    Route::post('bookings-activity/pay', 'BookingsController@pay')->middleware(['permission:manage_bookings']);
    // bookings

    Route::get('booking/need_pay_account/{id}/{type}', 'BookingsController@needPayAccount');
    Route::get('booking/need_pay_account/{id}/{type}', 'BookingsController@needPayAccount');
    Route::get('booking/booking_list_csv', 'BookingsController@bookingCsv');
    Route::get('booking/booking_list_pdf', 'BookingsController@bookingPdf');
    Route::get('payouts', 'PayoutsController@index')->middleware(['permission:view_payouts']);
    Route::get('payouts/commissions', 'PayoutsController@commissions')->middleware(['permission:view_payouts']);
    Route::match(array('GET', 'POST'), 'payouts/edit/{id}', 'PayoutsController@edit');
    Route::get('payouts/details/{id}', 'PayoutsController@details');
    Route::get('payouts/payouts_list_pdf', 'PayoutsController@payoutsPdf');
    Route::get('payouts/payouts_list_csv', 'PayoutsController@payoutsCsv');
    Route::group(['middleware' => 'permission:manage_reviews'], function () {
        Route::get('reviews', 'ReviewsController@index');
        Route::match(array('GET', 'POST'), 'edit_review/{id}', 'ReviewsController@edit');
        Route::get('reviews/review_search', 'ReviewsController@searchReview');
        Route::get('reviews/review_list_csv', 'ReviewsController@reviewCsv');
        Route::get('reviews/review_list_pdf', 'ReviewsController@reviewPdf');
    });

    // Activities
    Route::get('activities/add-requests', 'ActivitiesController@addRequests')->middleware(['permission:properties'])->name('activity.request');
    Route::get('listing-activity/{id}/approve', 'ActivitiesController@requestApprove')->middleware(['permission:properties']);
    Route::get('listing-activity/{id}/reject', 'ActivitiesController@requestReject')->middleware(['permission:properties']);
    Route::get('activities', 'ActivitiesController@index')->middleware(['permission:properties'])->name('activity.index');
    Route::match(array('GET', 'POST'), 'add-activity', 'ActivitiesController@add')->middleware(['permission:add_properties'])->name('activity.add');
    Route::get('activities/list_csv', 'ActivitiesController@propertyCsv')->name('activity.export-csv');
    Route::get('activities/list_pdf', 'ActivitiesController@propertyPdf')->name('activity.export-pdf');

    Route::group(['middleware' => 'permission:edit_properties', 'prefix' => 'activity', 'as' => 'activity.'], function () {
        Route::get('listing/approved/status/{id}', 'ActivitiesController@approvedStatus')->name('listing.approved.status');
        Route::match(array('GET', 'POST'), 'listing/{id}/photo_message', 'ActivitiesController@photoMessage')->name('photo-message');
        Route::match(array('GET', 'POST'), 'listing/{id}/photo_delete', 'ActivitiesController@photoDelete')->name('photo-delete');
        Route::match(array('GET', 'POST'), 'listing/{id}/update_status', 'ActivitiesController@update_status')->name('update-status');
        Route::match(array('POST'), 'listing/photo/make_default_photo', 'ActivitiesController@makeDefaultPhoto')->name('make-default-photo');
        Route::match(array('POST'), 'listing/photo/make_photo_serial', 'ActivitiesController@makePhotoSerial')->name('set-photo-serial');
        Route::match(array('GET', 'POST'), 'listing/{id}/{step}', 'ActivitiesController@listing')
            ->where(['id' => '[0-9]+', 'page' => 'basics|description|location|amenities|photos|pricing|calendar|details|booking'])->name('listing');
    });

    Route::match(array('GET', 'POST'), 'edit_activity/{id}', 'ActivitiesController@update')->middleware(['permission:edit_properties']);
    Route::get('delete-activity/{id}', 'ActivitiesController@delete')->middleware(['permission:delete_property'])->name('activity.delete');

    Route::group([
        'middleware' => 'permission:manage_amenities',
        'prefix' => 'activity',
        'as' => 'activity.'
    ], function () {
        Route::get('amenities', 'ActivityAmenitiesController@index')->name('amenities');
        Route::match(['GET', 'POST'], 'add-amenity', 'ActivityAmenitiesController@add')->name('add-amenity');
        Route::match(['GET', 'POST'], 'edit-amenity/{id}', 'ActivityAmenitiesController@update')->name('edit-amenity');
        Route::get('delete-amenity/{id}', 'ActivityAmenitiesController@delete')->name('delete-amenity');
    });

    // Route::get('reports', 'ReportsController@index')->middleware(['permission:manage_reports']);

    // For Reporting
    Route::group(['middleware' => 'permission:view_reports'], function () {
        Route::get('sales-report', 'ReportsController@salesReports');
        Route::get('sales-analysis', 'ReportsController@salesAnalysis');
        Route::get('reports/property-search', 'ReportsController@searchProperty');
        Route::get('overview-stats', 'ReportsController@overviewStats');
    });

    Route::group(['middleware' => 'permission:manage_amenities'], function () {
        Route::get('amenities', 'AmenitiesController@index');
        Route::match(array('GET', 'POST'), 'add-amenities', 'AmenitiesController@add');
        Route::match(array('GET', 'POST'), 'edit-amenities/{id}', 'AmenitiesController@update');
        Route::get('delete-amenities/{id}', 'AmenitiesController@delete');
    });

    Route::group(['middleware' => 'permission:manage_pages'], function () {
        Route::get('pages', 'PagesController@index');
        Route::match(array('GET', 'POST'), 'add-page', 'PagesController@add');
        Route::match(array('GET', 'POST'), 'edit-page/{id}', 'PagesController@update');
        Route::get('delete-page/{id}', 'PagesController@delete');
    });


    Route::group(['middleware' => 'permission:manage_admin'], function () {
        Route::get('admin-users', 'AdminController@index');
        Route::match(array('GET', 'POST'), 'add-admin', 'AdminController@add');
        Route::match(array('GET', 'POST'), 'edit-admin/{id}', 'AdminController@update');
        Route::match(array('GET', 'POST'), 'delete-admin/{id}', 'AdminController@delete');
    });

    // settings
    Route::group(['middleware' => 'permission:general_setting'], function () {
        Route::match(array('GET', 'POST'), 'settings', 'SettingsController@general')->middleware(['permission:general_setting']);
        Route::match(array('GET', 'POST'), 'settings/preferences', 'SettingsController@preferences')->middleware(['permission:preference']);
        Route::post('settings/delete_logo', 'SettingsController@deleteLogo');
        Route::post('settings/delete_favicon', 'SettingsController@deleteFavIcon');
        Route::match(array('GET', 'POST'), 'settings/fees', 'SettingsController@fees')->middleware(['permission:manage_fees']);
        Route::group(['middleware' => 'permission:manage_banners'], function () {
            Route::get('settings/banners', 'BannersController@index');
            Route::match(array('GET', 'POST'), 'settings/add-banners', 'BannersController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-banners/{id}', 'BannersController@update');
            Route::get('settings/delete-banners/{id}', 'BannersController@delete');
        });

        Route::group(['middleware' => 'permission:starting_cities_settings'], function () {
            Route::get('settings/addresses', 'StartingCitiesController@index');
            Route::match(array('GET', 'POST'), 'settings/add-address', 'StartingCitiesController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-address/{id}', 'StartingCitiesController@update');
            Route::get('settings/delete-address/{id}', 'StartingCitiesController@delete');
        });

        Route::group(['middleware' => 'permission:manage_property_type'], function () {
            Route::get('settings/property-type', 'PropertyTypeController@index');
            Route::match(array('GET', 'POST'), 'settings/add-property-type', 'PropertyTypeController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-property-type/{id}', 'PropertyTypeController@update');
            Route::get('settings/delete-property-type/{id}', 'PropertyTypeController@delete');
        });

        Route::group(['middleware' => 'permission:space_type_setting'], function () {
            Route::get('settings/space-type', 'SpaceTypeController@index');
            Route::match(array('GET', 'POST'), 'settings/add-space-type', 'SpaceTypeController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-space-type/{id}', 'SpaceTypeController@update');
            Route::get('settings/delete-space-type/{id}', 'SpaceTypeController@delete');
        });

        Route::group(['middleware' => 'permission:manage_bed_type'], function () {
            Route::get('settings/bed-type', 'BedTypeController@index');
            Route::match(array('GET', 'POST'), 'settings/add-bed-type', 'BedTypeController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-bed-type/{id}', 'BedTypeController@update');
            Route::get('settings/delete-bed-type/{id}', 'BedTypeController@delete');
        });

        Route::group(['middleware' => 'permission:manage_currency'], function () {
            Route::get('settings/currency', 'CurrencyController@index');
            Route::match(array('GET', 'POST'), 'settings/add-currency', 'CurrencyController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-currency/{id}', 'CurrencyController@update');
            Route::get('settings/delete-currency/{id}', 'CurrencyController@delete');
        });

        Route::group(['middleware' => 'permission:manage_country'], function () {
            Route::get('settings/country', 'CountryController@index');
            Route::match(array('GET', 'POST'), 'settings/add-country', 'CountryController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-country/{id}', 'CountryController@update');
            Route::get('settings/delete-country/{id}', 'CountryController@delete');
        });

        Route::group(['middleware' => 'permission:manage_amenities_type'], function () {
            Route::get('settings/amenities-type', 'AmenitiesTypeController@index');
            Route::match(array('GET', 'POST'), 'settings/add-amenities-type', 'AmenitiesTypeController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-amenities-type/{id}', 'AmenitiesTypeController@update');
            Route::get('settings/delete-amenities-type/{id}', 'AmenitiesTypeController@delete');
        });

        // activity settings
        Route::group(['middleware' => 'permission:manage_property_type'], function () {
            Route::get('settings/activity-type', 'ActivityTypeController@index');
            Route::match(array('GET', 'POST'), 'settings/add-activity-type', 'ActivityTypeController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-activity-type/{id}', 'ActivityTypeController@update');
            Route::get('settings/delete-activity-type/{id}', 'ActivityTypeController@delete');
        });


        Route::match(array('GET', 'POST'), 'settings/email', 'SettingsController@email')->middleware(['permission:email_settings']);

        Route::group(['middleware' => 'permission:manage_language'], function () {
            Route::get('settings/language', 'LanguageController@index');
            Route::match(array('GET', 'POST'), 'settings/add-language', 'LanguageController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-language/{id}', 'LanguageController@update');
            Route::get('settings/delete-language/{id}', 'LanguageController@delete');
        });

        Route::match(array('GET', 'POST'), 'settings/fees', 'SettingsController@fees')->middleware(['permission:manage_fees']);

        Route::group(['middleware' => 'permission:manage_metas'], function () {
            Route::get('settings/metas', 'MetasController@index');
            Route::match(array('GET', 'POST'), 'settings/edit_meta/{id}', 'MetasController@update');
        });

        Route::match(array('GET', 'POST'), 'settings/api-informations', 'SettingsController@apiInformations')->middleware(['permission:api_informations']);
        Route::match(array('GET', 'POST'), 'settings/payment-methods', 'SettingsController@paymentMethods')->middleware(['permission:payment_settings']);
        Route::match(array('GET', 'POST'), 'settings/bank/add', 'BankController@addBank')->middleware(['permission:payment_settings']);
        Route::match(array('GET', 'POST'), 'settings/bank/edit/{bank}', 'BankController@editBank')->middleware(['permission:payment_settings']);
        Route::get('settings/bank/{bank}', 'BankController@show')->middleware(['permission:payment_settings']);
        Route::get('settings/bank/delete/{bank}', 'BankController@deleteBank')->middleware(['permission:payment_settings']);
        Route::match(array('GET', 'POST'), 'settings/social-links', 'SettingsController@socialLinks')->middleware(['permission:social_links']);

        Route::match(array('GET', 'POST'), 'settings/social-logins', 'SettingsController@socialLogin')->middleware(['permission:social_logins']);;

        Route::group(['middleware' => 'permission:manage_roles'], function () {
            Route::get('settings/roles', 'RolesController@index');
            Route::match(array('GET', 'POST'), 'settings/add-role', 'RolesController@add');
            Route::match(array('GET', 'POST'), 'settings/edit-role/{id}', 'RolesController@update');
            Route::get('settings/delete-role/{id}', 'RolesController@delete');
        });

        Route::group(['middleware' => 'permission:database_backup'], function () {
            Route::get('settings/backup', 'BackupController@index');
            Route::get('backup/save', 'BackupController@add');
            Route::get('backup/download/{id}', 'BackupController@download');
        });

        Route::group(['middleware' => 'permission:manage_email_template'], function () {
            Route::get('email-template/{id}', 'EmailTemplateController@index');
            Route::post('email-template/{id}', 'EmailTemplateController@update');
        });

        Route::group(['middleware' => 'permission:manage_testimonial'], function () {
            Route::get('testimonials', 'TestimonialController@index');
            Route::match(array('GET', 'POST'), 'add-testimonials', 'TestimonialController@add');
            Route::match(array('GET', 'POST'), 'edit-testimonials/{id}', 'TestimonialController@update');
            Route::get('delete-testimonials/{id}', 'TestimonialController@delete');
        });
    });
});

//only can view if admin is not logged in if they are logged in then they will be redirect to dashboard
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'no_auth:admin'], function () {
    Route::get('login', 'AdminController@login');
});


Route::post('admin/authenticate', 'Admin\AdminController@authenticate');

Route::match(['GET', 'POST'], 'admin/settings/sms', 'Admin\SettingsController@smsSettings');
Route::match(['get', 'post'], 'upload_image', 'Admin\PagesController@uploadImage')->name('upload');
