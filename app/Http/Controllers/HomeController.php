<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Mail\ContactPageMail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Cache;


use App\Models\{
    Activity,
    ActivityAddress,
    Currency,
    Properties,
    Page,
    Settings,
    StartingCities,
    Testimonials,
    Language,
    Admin,
    Amenities,
    AmenityType,
    PropertyAddress,
    PropertyType,
    SpaceType,
    User,
    Wallet
};
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

// require base_path() . '/vendor/autoload.php';

class HomeController extends Controller
{
    private $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index(Request $request)
    {
        $data['starting_cities'] = StartingCities::getAll();
        $data['hotels']          = Properties::recommendedHotel();
        $data['guestHouses']     = Properties::recommendedGuestHouse();
        $data['activities']      = Activity::recommendedActivities();
        $data['testimonials']    = Testimonials::getAll();
        $sessionLanguage   = Session::get('language');
        $language          = Settings::getAll()->where('name', 'default_language')->where('type', 'general')->first();
        $languageDetails   = Language::where(['id' => $language->value])->first();

        if (!($sessionLanguage)) {
            Session::pull('language');
            Session::put('language', $languageDetails->short_name);
            App::setLocale($languageDetails->short_name);
        }

        $pref = Settings::getAll();

        $prefer = [];

        if (!empty($pref)) {
            foreach ($pref as $value) {
                $prefer[$value->name] = $value->value;
            }
            Session::put($prefer);
        }
        $data['date_format'] = Settings::getAll()->firstWhere('name', 'date_format_type')->value;

        // request
        $data['location'] = $request->input('location');
        $data['checkin'] = $request->input('checkin');
        $data['checkout'] = $request->input('checkout');
        $data['guest'] = $request->input('guest');
        $data['bedrooms'] = $request->input('bedrooms');
        $data['beds'] = $request->input('beds');
        $data['bathrooms'] = $request->input('bathrooms');
        $data['min_price'] = $request->input('min_price');
        $data['max_price'] = $request->input('max_price');

        $data['space_type'] = SpaceType::getAll()->where('status', 'Active')->pluck('name', 'id');
        $data['property_type'] = PropertyType::getAll()->where('status', 'Active')->pluck('name', 'id');
        $data['amenities'] = Amenities::where('status', 'Active')->get();
        $data['amenities_type'] = AmenityType::pluck('name', 'id');

        $data['property_type_selected'] = explode(',', $request->input('property_type'));
        $data['space_type_selected'] = explode(',', $request->input('space_type'));
        $data['amenities_selected'] = explode(',', $request->input('amenities'));
        $currency = Currency::getAll();
        if (Session::get('currency')) $data['currency_symbol'] = $currency->firstWhere('code', Session::get('currency'))->symbol;
        else $data['currency_symbol'] = $currency->firstWhere('default', 1)->symbol;
        $minPrice = Settings::getAll()->where('name', 'min_search_price')->first()->value;
        $maxPrice = Settings::getAll()->where('name', 'max_search_price')->first()->value;
        $data['default_min_price'] = $this->helper->convert_currency(Currency::getAll()->firstWhere('default')->code, '', $minPrice);
        $data['default_max_price'] = $this->helper->convert_currency(Currency::getAll()->firstWhere('default')->code, '', $maxPrice);
        if (!$data['min_price']) {
            $data['min_price'] = $data['default_min_price'];
            $data['max_price'] = $data['default_max_price'];
        }

        return view('home.home', $data);
    }

    public function phpinfo()
    {
        echo phpinfo();
    }

    public function login()
    {
        return view('home.login');
    }

    public function setSession(Request $request)
    {
        if ($request->currency) {
            Session::put('currency', $request->currency);
            $symbol = Currency::code_to_symbol($request->currency);
            Session::put('symbol', $symbol);
        } elseif ($request->language) {
            Session::put('language', $request->language);
            $name = language::name($request->language);
            Session::put('language_name', $name);
            App::setLocale($request->language);
        }
    }

    public function cancellation_policies()
    {
        return view('home.cancellation_policies');
    }

    public function staticPages(Request $request)
    {
        $pages = Page::where(['url' => $request->name, 'status' => 'Active']);
        if (!$pages->count()) {
            abort('404');
        }
        $pages           = $pages->first();
        $data['content'] = str_replace(['SITE_NAME', 'SITE_URL'], [SITE_NAME, url('/')], $pages->content);
        $data['title']   = $pages->name;
        $data['url']     = url('/') . '/';
        $data['img']     = $data['url'] . 'public/images/2222hotel_room2.jpg';

        return view('home.static_pages', $data);
    }

    public function contactPage()
    {
        $data['title']   = "Contact";
        return view('home.contact_page', $data);
    }

    public function contactForm(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Mail::raw($data['message'], function ($message) use ($data) {
            $to = "atarmanarif@gmail.com";
            // $to = "contact@travelobug.pk";
            $sender = "contact_page@travelobug.pk";

            $message->to($to, 'TravelOBug.pk');
            $message->from($data['email'], $data['name']);
            $message->sender($sender, 'TravelOBug.pk');
            $message->subject($data['subject']);
        });

        return back()->with('success', 'Message sent successfully');
    }


    public function activateDebugger()
    {
        setcookie('debugger', 0);
    }

    public function walletUser(Request $request)
    {

        $users = User::all();
        $wallet = Wallet::all();


        if (!$users->isEmpty() && $wallet->isEmpty()) {
            foreach ($users as $key => $user) {

                Wallet::create([
                    'user_id' => $user->id,
                    'currency_id' => 1,
                    'balance' => 0,
                    'is_active' => 0
                ]);
            }
        }

        return redirect('/');
    }

    public function addressSearch()
    {
        $search = request('search');
        return $search ? StartingCities::where('name', 'LIKE', '%' . $search . '%')->get() : [];
    }

    public function homeAddressSearch()
    {
        $search = request('search');
        $category = request('category');
        $result = [];

        $address = StartingCities::select('name')->orderBy('name')
            ->where('name', 'LIKE', '%' . $search . '%')->get()->toArray();
        if ($category == 'activities') {
            $result = ActivityAddress::select('address_line_1 as name')->whereHas('activity', function ($query) {
                $query->where('approved', 1)->where('status', 'listed');
            })
                ->where('address_line_1', 'LIKE', '%' . $search . '%')->groupBy('address_line_1')
                ->get()->toArray();
        } else {
            $result = PropertyAddress::select('address_line_1 as name')->whereHas('properties', function ($query) {
                $query->where('approved', 1)->where('status', 'listed');
            })
                ->where('address_line_1', 'LIKE', '%' . $search . '%')->groupBy('address_line_1')
                ->get()->toArray();
        }

        $result = array_merge($address, $result);

        return $result;
    }
}
