<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    User,
    Properties,
    Bookings
};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $data['total_users_count']        = User::count();
        $data['total_property_count']     = Properties::count();
        $data['total_reservations_count'] = Bookings::count();

        $data['today_users_count']        = User::whereDate('created_at', DB::raw('CURDATE()'))->count();
        // $data['today_property_count']     = Properties::whereDate('created_at', DB::raw('CURDATE()'))->count();
        // $data['today_reservations_count'] = Bookings::whereDate('created_at', DB::raw('CURDATE()'))->count();

        $data['pending_property_count']     = Properties::where('approved', 0)->count();
        $data['pending_booking_count'] = Bookings::whereNull('accepted_at')->count();

        $properties = new Properties;
        $data['propertiesList'] = $properties->getLatestProperties();

        $bookings = new Bookings;
        $data['bookingList'] = $bookings->getBookingLists();
        return view('admin.dashboard', $data);
    }
}
