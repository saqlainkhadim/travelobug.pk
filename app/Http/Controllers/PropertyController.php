<?php

namespace App\Http\Controllers;

use Cache;

use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CalendarController;
use App\Models\{Favourite, Properties, PropertyDetails, PropertyAddress, PropertyPhotos, PropertyPrice, PropertyType, PropertyDates, PropertyDescription, Currency, Settings, Bookings, SpaceType, BedType, PropertySteps, Country, Amenities, AmenityType};


class PropertyController extends Controller
{
    public $helper;
    public function __construct()
    {
        $this->helper = new Common;
    }

    public function userProperties(Request $request)
    {
        switch ($request->status) {
            case 'Listed':
            case 'Unlisted':
                $pram = [['status', '=', $request->status]];
                break;
            default:
                $pram = [];
                break;
        }

        $data['status'] = $request->status;
        $data['properties'] = Properties::with('property_price', 'property_address')
            ->where('host_id', Auth::id())
            ->where($pram)
            ->orderBy('id', 'desc')
            ->paginate(Session::get('row_per_page'));
        $data['currentCurrency'] =  $this->helper->getCurrentCurrency();

        return view('property.listings', $data);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'category'         => 'required',
                'property_type_id' => 'required',
                'space_type'       => 'required',
                'accommodates'     => 'required',
                'map_address'      => 'required',
            );

            $fieldNames = array(
                'property_type_id'  => 'Home Type',
                'space_type'        => 'Room Type',
                'accommodates'      => 'Accommodates',
                'map_address'       => 'City',
                'category'  => 'Property Type',
            );

            $validator = Validator::make($request->all(), $rules, [], $fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $property                = new Properties;
                $property->host_id       = Auth::id();
                $property->name          = SpaceType::getAll()->find($request->space_type)->name . ' in ' . $request->city;
                $property->property_type = $request->property_type_id;
                $property->category      = $request->category;
                $property->space_type    = $request->space_type;
                $property->accommodates  = $request->accommodates;
                $property->status        = 'listed';
                $property->save();

                $property_address                 = new PropertyAddress;
                $property_address->property_id    = $property->id;
                $property_address->address_line_1 = $request->route;
                $property_address->city           = $request->city;
                $property_address->state          = $request->state;
                $property_address->country        = $request->country;
                $property_address->postal_code    = $request->postal_code;
                $property_address->latitude       = $request->latitude;
                $property_address->longitude      = $request->longitude;
                $property_address->save();

                $property_price                 = new PropertyPrice;
                $property_price->property_id    = $property->id;
                $property_price->currency_code  = Session::get('currency');
                $property_price->save();

                $property_steps                   = new PropertySteps;
                $property_steps->property_id      = $property->id;
                $property_steps->save();

                $property_description              = new PropertyDescription;
                $property_description->property_id = $property->id;
                $property_description->save();

                return redirect('listing/' . $property->id . '/basics');
            }
        }

        $data['property_type'] = PropertyType::getAll()->where('status', 'Active')->pluck('name', 'id');
        $data['space_type']    = SpaceType::getAll()->where('status', 'Active')->pluck('name', 'id');

        return view('property.create', $data);
    }

    public function listing(Request $request, CalendarController $calendar)
    {
        $step            = $request->step;
        $property_id     = $request->id;
        $data['step']    = $step;
        $data['result']  = Properties::where('host_id', Auth::id())->findOrFail($property_id);
        $data['details'] = PropertyDetails::pluck('value', 'field');
        $data['missed']  = PropertySteps::where('property_id', $request->id)->first();


        if ($step == 'basics') {
            if ($request->isMethod('post')) {
                $property                = Properties::find($property_id);
                $property->bedrooms      = $request->bedrooms;
                $property->beds          = $request->beds;
                $property->bathrooms     = $request->bathrooms;
                $property->bed_type      = $request->bed_type;
                $property->property_type = $request->property_type;
                $property->space_type    = $request->space_type;
                $property->accommodates  = $request->accommodates;
                $property->save();

                $property_steps         = PropertySteps::where('property_id', $property_id)->first();
                $property_steps->basics = 1;
                $property_steps->save();
                return redirect('listing/' . $property_id . '/description');
            }

            $data['bed_type']      = BedType::getAll()->pluck('name', 'id');
            $data['property_type'] = PropertyType::getAll()->where('status', 'Active')->pluck('name', 'id');
            $data['space_type']    = SpaceType::getAll()->pluck('name', 'id');

            if ($this->scattered()) {
                Session::flush();

                return view('vendor.installer.errors.user');
            }
        } elseif ($step == 'description') {
            if ($request->isMethod('post')) {

                $rules = array(
                    'name'     => 'required|max:50',
                    'summary'  => 'required|max:1000'
                );

                $fieldNames = array(
                    'name'     => 'Name',
                    'summary'  => 'Summary',
                );

                $validator = Validator::make($request->all(), $rules, [], $fieldNames);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                } else {
                    $property           = Properties::find($property_id);
                    $property->name     = $request->name;
                    $property->slug     = $this->helper->pretty_url($request->name);
                    $property->save();

                    $property_description              = PropertyDescription::where('property_id', $property_id)->first();
                    $property_description->summary     = $request->summary;
                    $property_description->save();

                    $property_steps              = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->description = 1;
                    $property_steps->save();
                    return redirect('listing/' . $property_id . '/location');
                }
            }
            $data['description']       = PropertyDescription::where('property_id', $property_id)->first();
        } elseif ($step == 'details') {
            if ($request->isMethod('post')) {
                $property_description                     = PropertyDescription::where('property_id', $property_id)->first();
                $property_description->about_place        = $request->about_place;
                $property_description->place_is_great_for = $request->place_is_great_for;
                $property_description->guest_can_access   = $request->guest_can_access;
                $property_description->interaction_guests = $request->interaction_guests;
                $property_description->other              = $request->other;
                $property_description->about_neighborhood = $request->about_neighborhood;
                $property_description->get_around         = $request->get_around;
                $property_description->save();

                return redirect('listing/' . $property_id . '/description');
            }
        } elseif ($step == 'location') {
            if ($request->isMethod('post')) {
                $rules = array(
                    'address_line_1'    => 'required|max:255',
                    'address_line_2'    => 'max:255',
                    'country'           => 'required',
                    'city'              => 'required',
                    'state'             => 'required',
                    // 'latitude'          => 'required|not_in:0',
                );

                $fieldNames = array(
                    'address_line_1' => 'Address Line 1',
                    'country'        => 'Country',
                    'city'           => 'City',
                    'state'          => 'State',
                    'latitude'       => 'Map',
                );

                $messages = [
                    'not_in' => 'Please set :attribute pointer',
                ];

                $validator = Validator::make($request->all(), $rules, $messages, $fieldNames);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                } else {
                    $property_address                 = PropertyAddress::where('property_id', $property_id)->first();
                    $property_address->address_line_1 = $request->address_line_1;
                    $property_address->address_line_2 = $request->address_line_2;
                    $property_address->latitude       = $request->latitude;
                    $property_address->longitude      = $request->longitude;
                    $property_address->city           = $request->city;
                    $property_address->state          = $request->state;
                    $property_address->country        = $request->country;
                    $property_address->postal_code    = $request->postal_code;
                    $property_address->save();

                    $property_steps           = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->location = 1;
                    $property_steps->save();

                    return redirect('listing/' . $property_id . '/amenities');
                }
            }
            $data['country']       = Country::pluck('name', 'short_name');
        } elseif ($step == 'amenities') {
            if ($request->isMethod('post') && is_array($request->amenities)) {
                $rooms            = Properties::find($request->id);
                $rooms->amenities = implode(',', $request->amenities);
                $rooms->save();

                return redirect('listing/' . $property_id . '/photos');
            }
            $data['property_amenities'] = explode(',', $data['result']->amenities);
            $data['amenities']          = Amenities::where('status', 'Active')->get();
            $data['amenities_type']     = AmenityType::get();
        } elseif ($step == 'photos') {
            /***************************************
             ** ***** Property photo upload ***** **
             ***************************************/
            if ($request->isMethod('post')) {
                if ($request->crop == 'crop' && $request->photos) {
                    $baseText = explode(";base64,", $request->photos);
                    $name = explode(".", $request->img_name);
                    $convertedImage = base64_decode($baseText[1]);
                    $request->request->add(['type' => end($name)]);
                    $request->request->add(['image' => $convertedImage]);


                    $validate = Validator::make($request->all(), [
                        'type' => 'required|in:png,jpg,JPG,JPEG,jpeg,bmp',
                        'img_name' => 'required',
                        'photos' => 'required',
                    ]);
                } else {
                    $validate = Validator::make($request->all(), [
                        'file' => 'required|file|mimes:jpg,jpeg,bmp,png,gif,JPG',
                        // 'file' => 'max:5120'
                        // 'file' => 'dimensions:\min_width=640,min_height=360'
                    ]);
                }

                if ($validate->fails()) {
                    return back()->withErrors($validate)->withInput();
                }

                $path = public_path('images/property/' . $property_id . '/');

                if (!file_exists($path)) {
                    @mkdir($path, 0777, true);
                }

                $image = null;
                $uploaded = false;
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $image = optimize_proact_image_topath($file, $path);
                    $uploaded = true;
                }

                if ($uploaded) {
                    $photos = new PropertyPhotos;
                    $photos->property_id = $property_id;
                    $photos->photo = $image;
                    $photos->serial = 1;
                    $photos->cover_photo = 1;

                    $exist = PropertyPhotos::orderBy('serial', 'desc')
                        ->select('serial')
                        ->where('property_id', $property_id)
                        ->take(1)->first();

                    if (!empty($exist->serial)) {
                        $photos->serial = $exist->serial + 1;
                        $photos->cover_photo = 0;
                    }
                    $photos->save();
                    $property_steps = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->photos = 1;
                    $property_steps->save();
                }

                return redirect('listing/' . $property_id . '/photos')->with('success', 'File Uploaded Successfully!');
            }

            $data['photos'] = PropertyPhotos::where('property_id', $property_id)
                ->orderBy('serial', 'asc')
                ->get();
        } elseif ($step == 'pricing') {
            if ($request->isMethod('post')) {
                $bookings = Bookings::where('property_id', $property_id)->where('currency_code', '!=', $request->currency_code)->first();
                if ($bookings) {
                    return back()->withErrors(['currency' => trans('messages.error.currency_change')]);
                }
                $rules = array(
                    'price' => 'required|numeric|min:5',
                    'weekly_discount' => 'nullable|numeric|max:99|min:0',
                    'monthly_discount' => 'nullable|numeric|max:99|min:0'
                );

                $fieldNames = array(
                    'price'  => 'Price',
                    'weekly_discount' => 'Weekly Discount Percent',
                    'monthly_discount' => 'Monthly Discount Percent'
                );

                $validator = Validator::make($request->all(), $rules, [], $fieldNames);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                } else {
                    $property_price                   = PropertyPrice::where('property_id', $property_id)->first();
                    $property_price->price            = $request->price;
                    $property_price->weekly_discount  = $request->weekly_discount;
                    $property_price->monthly_discount = $request->monthly_discount;
                    $property_price->currency_code    = $request->currency_code;
                    $property_price->cleaning_fee     = $request->cleaning_fee;
                    $property_price->guest_fee        = $request->has('additional_guest_pricing') ? $request->guest_fee : 0;
                    $property_price->guest_after      = $request->has('additional_guest_pricing') ? $data['result']->accommodates : 0;  //$request->guest_after;
                    $property_price->security_fee     = $request->security_fee;
                    $property_price->weekend_price    = $request->weekend_price;
                    $property_price->save();

                    $property_steps = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->pricing = 1;
                    $property_steps->save();

                    return redirect('listing/' . $property_id . '/booking');
                }
            }
        } elseif ($step == 'booking') {
            if ($request->isMethod('post')) {

                $property_steps          = PropertySteps::where('property_id', $property_id)->first();
                $property_steps->booking = 1;
                $property_steps->save();

                $properties               = Properties::find($property_id);
                $properties->booking_type = $request->booking_type;
                $properties->save();

                return redirect('listing/' . $property_id . '/calendar');
            }
        } elseif ($step == 'calendar') {
            $data['calendar'] = $calendar->generate($request->id);
        }

        return view("listing.$step", $data);
    }


    public function updateStatus(Request $request)
    {
        $property_id = $request->id;
        $reqstatus = $request->status;
        if ($reqstatus == 'Listed') {
            $status = 'Unlisted';
        } else {
            $status = 'Listed';
        }
        $properties         = Properties::where('host_id', Auth::id())->find($property_id);
        $properties->status = $status;
        $properties->save();
        return  response()->json($properties);
    }

    public function getPrice(Request $request)
    {
        return $this->helper->getPrice($request->property_id, $request->checkin, $request->checkout, $request->guest_count);
    }

    public function single(Request $request)
    {

        $data['property_slug'] = $request->slug;


        $data['result'] = $result = Properties::where('slug', $request->slug)->first();

        if (empty($result)) {
            abort('404');
        }

        $data['property_id'] = $id = $result->id;

        $data['property_photos']     = PropertyPhotos::where('property_id', $id)->orderBy('serial', 'asc')
            ->get();

        $data['amenities']        = Amenities::normal($id);
        $data['safety_amenities'] = Amenities::security($id);

        $property_address         = $data['result']->property_address;

        $latitude                 = $property_address->latitude ?? 0;

        $longitude                = $property_address->longitude ?? 0;

        $data['checkin']          = (isset($request->checkin) && $request->checkin != '') ? $request->checkin : '';
        $data['checkout']         = (isset($request->checkout) && $request->checkout != '') ? $request->checkout : '';

        $data['guests']           = (isset($request->guests) && $request->guests != '') ? $request->guests : '';

        $data['similar']  = Properties::join('property_address', function ($join) {
            $join->on('properties.id', '=', 'property_address.property_id');
        })
            ->select(DB::raw('*, ( 3959 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude ) ) ) ) as distance'))
            ->having('distance', '<=', 30)
            ->where('properties.host_id', '!=', Auth::id())
            ->where('properties.id', '!=', $id)
            ->where('properties.status', 'Listed')
            ->where('approved', 1)
            ->get();

        $data['title']    =   $data['result']->name . ' in ' . $data['result']->property_address->city;

        $data['symbol'] = $this->helper->getCurrentCurrencySymbol();
        $data['shareLink'] = url('/') . '/' . 'properties/' . $data['property_id'];

        $data['date_format'] = Settings::getAll()->firstWhere('name', 'date_format_type')->value;

        // return $data;
        return view('property.single', $data);
    }

    public function currencySymbol(Request $request)
    {
        $symbol          = Currency::code_to_symbol($request->currency);
        $data['success'] = 1;
        $data['symbol']  = $symbol;

        return json_encode($data);
    }

    public function photoMessage(Request $request)
    {
        $property = Properties::find($request->id);
        if ($property->host_id == Auth::user()->id) {
            $photos = PropertyPhotos::find($request->photo_id);
            $photos->message = $request->messages;
            $photos->save();
        }

        return json_encode(['success' => 'true']);
    }

    public function photoDelete(Request $request)
    {
        $property   = Properties::find($request->id);
        if ($property->host_id == Auth::user()->id) {
            $photo = PropertyPhotos::find($request->photo_id);
            $path = public_path('images/property/' . $photo->property_id . '/');
            if (file_exists($path . $photo->photo)) {
                @unlink($path . $photo->photo);
            }
            $photo->delete();
        }

        return json_encode(['success' => 'true']);
    }

    public function makeDefaultPhoto(Request $request)
    {

        if ($request->option_value == 'Yes') {
            PropertyPhotos::where('property_id', '=', $request->property_id)
                ->update(['cover_photo' => 0]);

            $photos = PropertyPhotos::find($request->photo_id);
            $photos->cover_photo = 1;
            $photos->save();
        }
        return json_encode(['success' => 'true']);
    }

    public function makePhotoSerial(Request $request)
    {

        $photos         = PropertyPhotos::find($request->id);
        $photos->serial = $request->serial;
        $photos->save();

        return json_encode(['success' => 'true']);
    }


    public function set_slug()
    {

        $properties   = Properties::where('slug', NULL)->get();
        foreach ($properties as $key => $property) {

            $property->slug     = $this->helper->pretty_url($property->name);
            $property->save();
        }
        return redirect('/');
    }

    public function userBookmark()
    {

        $data['bookings'] = Favourite::with(['properties' => function ($q) {
            $q->with('property_address');
        }])->where(['user_id' => Auth::id(), 'status' => 'Active'])->orderBy('id', 'desc')
            ->paginate(Settings::getAll()->where('name', 'row_per_page')->first()->value);
        return view('users.favourite', $data);
    }

    public function addEditBookMark()
    {
        $property_id = request('id');
        $user_id = request('user_id');

        $favourite = Favourite::where('property_id', $property_id)->where('user_id', $user_id)->first();

        if (empty($favourite)) {
            $favourite = Favourite::create([
                'property_id' => $property_id,
                'user_id' => $user_id,
                'status' => 'Active',
            ]);
        } else {
            $favourite->status = ($favourite->status == 'Active') ? 'Inactive' : 'Active';
            $favourite->save();
        }

        return response()->json([
            'favourite' => $favourite
        ]);
    }

    public function scattered()
    {
        if (!g_e_v()) {
            return true;
        }
        if (!g_c_v()) {
            try {
                $d_ = g_d();
                $e_ = g_e_v();
                $e_ = explode('.', $e_);
                $c_ = md5($d_ . $e_[1]);
                if ($e_[0] == $c_) {
                    p_c_v();
                    return false;
                }
                return true;
            } catch (\Exception $e) {
                return true;
            }
        }
        return false;
    }
}
