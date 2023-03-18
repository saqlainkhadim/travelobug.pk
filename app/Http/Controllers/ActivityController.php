<?php

namespace App\Http\Controllers;

use App\Actions\ActivitiesAction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\PropertiesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Helpers\Common;
use App\Http\Controllers\Admin\CalendarController;
use App\DataTables\ActivitiesDataTable;

use App\Models\{Activity, ActivityAddress, ActivityAmenity, ActivityDescription, ActivityPrice, ActivityStep, ActivityType, ActivityPhotos, Currency, Country, Amenities, User, Settings, Bookings, Favourite};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ActivityController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function userActivities(Request $request)
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
        $data['activities'] = Activity::with('price', 'address')
            ->where('host_id', Auth::id())
            ->where($pram)
            ->orderBy('id', 'desc')
            ->paginate(Session::get('row_per_page'));
        $data['currentCurrency'] =  $this->helper->getCurrentCurrency();
        return view('activity.listings', $data);
    }

    public function create(Request $request)
    {

        if ($request->isMethod('post')) {
            $rules = array(
                'activity_name'    => 'required',
                'activity_type_id' => 'required',
                'map_address'      => 'required',
                'host_id'          => 'required',
                'what_you_do'      => 'required',
                'what_include'     => 'required',
            );

            $fieldNames = array(
                'activity_name'    => 'Activity Name',
                'activity_type_id' => 'Activity Type',
                'map_address'      => 'City',
                'host_id'          => 'Host',
                'what_you_do'      => 'What you will do',
                'what_include'     => 'What includes',
            );

            $data = $request->all();

            $validator = Validator::make($request->all(), $rules, [], $fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $activity             = new Activity();
            $activity_price       = new ActivityPrice();
            $activity_address     = new ActivityAddress();
            $activity_description = new ActivityDescription();

            $activity->host_id       = $request->host_id;
            $activity->name          = $request->activity_name;
            $activity->activity_type = $request->activity_type_id;
            $activity->status        = 'listed';
            $activity->what_you_do   = $request->what_you_do;
            $activity->what_include  = $request->what_include;
            $activity->save();

            $address = [];
            if ($data['street_number'] ?? false && $data['street_number'] != '') array_push($address, $data['street_number']);
            if ($data['route'] ?? false && $data['route'] != '') array_push($address, $data['route']);
            $address_line_1 = join(", ", $address);

            $activity_address->activity_id    = $activity->id;
            $activity_address->address_line_1 = $address_line_1;
            $activity_address->city           = $request->city;
            $activity_address->state          = $request->state;
            $activity_address->country        = $request->country;
            $activity_address->postal_code    = $request->postal_code;
            $activity_address->latitude       = $request->latitude;
            $activity_address->longitude      = $request->longitude;


            $activity_address->save();

            $activity_price->activity_id    = $activity->id;
            $activity_price->currency_code  = Session::get('currency');
            $activity_price->save();

            $activity_description->activity_id = $activity->id;
            $activity_description->save();

            return redirect()->route('user.activity.listing', [$activity->id, 'basics']);
        }

        $data['users']         = User::where('status', 'Active')->get();
        $data['activityTypes'] = ActivityType::where('status', 'Active')->pluck('name', 'id');

        return view('activity.create', $data);
    }

    public function listing(Request $request, CalendarController $calendar)
    {

        $step            = $request->step;
        $activity_id     = $request->id;

        $action = new ActivitiesAction;

        $data['step']    = $step;
        $data['result']  = Activity::findOrFail($activity_id);

        switch ($step) {
            case 'basics':
                if ($request->isMethod('post')) {
                    return $action->basic($request, $activity_id);
                }
                $data['activity_type'] = ActivityType::pluck('name', 'id');
                break;
            case 'description':
                if ($request->isMethod('post')) {
                    return $action->description($request, $activity_id);
                }
                $data['description'] = ActivityDescription::where('activity_id', $activity_id)->first();
                break;
            case 'details':
                if ($request->isMethod('post')) {
                    return $action->details($request, $activity_id);
                }
                break;
            case 'location':
                if ($request->isMethod('post')) {
                    return $action->location($request, $activity_id);
                }
                $data['country'] = Country::pluck('name', 'short_name');
                break;
            case 'amenities':
                if ($request->isMethod('post')) {
                    return $action->amenities($request, $activity_id);
                }
                $data['activity_amenities'] = explode(',', $data['result']->amenities);
                $amenities = ActivityAmenity::where('status', 'Active')->get();
                $chunkSize = $amenities->count() > 1 ? intval($amenities->count() / 2) : 1;
                $data['amenities'] = $amenities->count() > 0 ? $amenities->chunk($chunkSize) : collect([]);
                break;
            case 'photos':
                if ($request->isMethod('post')) {

                    $validate = Validator::make($request->all(), [
                        'file' => 'required|file|mimes:jpg,jpeg,bmp,png,gif,JPG',
                        // 'file' => Rule::dimensions(['min_width' => 640, 'min_height' => 360])
                    ]);

                    if ($validate->fails()) {
                        return back()->withErrors($validate)->withInput();
                    }

                    $path = public_path('images/activity/' . $activity_id . '/');

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
                        $photo_exist_first = ActivityPhotos::where('activity_id', $activity_id)->count();
                        if ($photo_exist_first != 0) {
                            $photo_exist = ActivityPhotos::orderBy('serial', 'desc')
                                ->where('activity_id', $activity_id)
                                ->take(1)->first();
                        }
                        $photos = new ActivityPhotos;
                        $photos->activity_id = $activity_id;
                        $photos->photo = $image;
                        if ($photo_exist_first != 0) {
                            $photos->serial = $photo_exist->serial + 1;
                        } else {
                            $photos->serial = $photo_exist_first + 1;
                        }
                        if (!$photo_exist_first) {
                            $photos->cover_photo = 1;
                        }

                        $photos->save();
                        $activity_steps = ActivityStep::where('activity_id', $activity_id)->first();
                        $activity_steps->photos = 1;
                        $activity_steps->save();
                    }

                    return redirect()->route('user.activity.listing', [$activity_id, 'photos'])->with('success', 'File Uploaded Successfully!');
                }
                $data['photos']    = ActivityPhotos::where('activity_id', $activity_id)->orderBy('serial', 'asc')->get();
            case 'pricing':
                if ($request->isMethod('post')) {
                    $bookings = Bookings::where('property_id', $activity_id)->where('currency_code', '!=', $request->currency_code)->first();
                    if ($bookings) {
                        $this->helper->one_time_message('error', trans('messages.error.currency_change'));
                        return redirect()->back();
                    }
                    $rules = array(
                        'price' => 'required|numeric|min:5',
                    );

                    $fieldNames = array(
                        'price'  => 'Price',
                    );

                    $validator = Validator::make($request->all(), $rules, [], $fieldNames);

                    if ($validator->fails()) {
                        return back()->withErrors($validator)->withInput();
                    }
                    $activity_price                    = ActivityPrice::where('activity_id', $activity_id)->first();
                    $activity_price->price             = $request->price;
                    $activity_price->discount   = $request->discount;
                    $activity_price->save();

                    $activity_steps = ActivityStep::where('activity_id', $activity_id)->first();
                    $activity_steps->pricing = 1;
                    $activity_steps->save();

                    return redirect(route('user.activity.listing', [$activity_id, 'booking']));
                }
                break;
            case 'booking':
                if ($request->isMethod('post')) {
                    $activity = Activity::find($activity_id);
                    $activity->booking_type = $request->booking_type;
                    $activity->save();

                    $activity_steps          = ActivityStep::where('activity_id', $activity_id)->first();
                    $activity_steps->booking = 1;
                    $activity_steps->save();

                    return redirect(route('user.activity.listing', [$activity_id, 'calendar']));
                }
                break;
        }

        if ($step == 'calendar') {
            $data['calendar'] = $calendar->generateForActivity($request->id);
        }

        return view("activity.listing.$step", $data);
    }


    public function updateStatus(Request $request)
    {
        $activity_id = $request->id;
        $reqstatus = $request->status;
        if ($reqstatus == 'Listed') {
            $status = 'Unlisted';
        } else {
            $status = 'Listed';
        }
        $properties = Activity::where('host_id', Auth::id())->find($activity_id);
        $properties->status = $status;
        $properties->save();
        return  response()->json($properties);
    }

    public function getPrice(Request $request)
    {
        return $this->helper->getActivityPrice($request->activity_id, $request->checkin, $request->checkout, $request->guest_count);
    }

    public function single(Request $request)
    {

        $data['activity_slug'] = $request->slug;
        $data['result'] = $result = Activity::where('slug', $request->slug)->first();
        if (empty($result)) {
            abort('404');
        }

        $data['activity_id'] = $id = $result->id;
        $data['activity_photos']   = ActivityPhotos::where('activity_id', $id)->orderBy('serial', 'asc')->get();
        $data['amenities']        = ActivityAmenity::aminities($id);
        $activity_address         = $data['result']->address;
        $latitude                 = $activity_address->latitude;
        $longitude                = $activity_address->longitude;
        $data['checkin']          = (isset($request->checkin) && $request->checkin != '') ? $request->checkin : '';
        $data['checkout']         = (isset($request->checkout) && $request->checkout != '') ? $request->checkout : '';

        $data['guests']           = (isset($request->guests) && $request->guests != '') ? $request->guests : '';

        $data['similar']  = Activity::join('activity_addresses', function ($join) {
            $join->on('activities.id', '=', 'activity_addresses.activity_id');
        })
            ->with(['price'])
            ->select(
                'activities.*',
                'activity_addresses.*',
                // DB::raw('( 3959 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude ) ) ) ) as distance'),
                'activity_addresses.id as address_id',
                'activities.id as id',
            )
            // ->having('distance', '<=', 30)
            ->where('activities.host_id', '!=', Auth::id())
            ->where('activities.id', '!=', $id)
            ->where('activities.status', 'Listed')
            ->limit(8)
            ->get();

        $data['title']    =   $data['result']->name . ' in ' . $data['result']->address->city;
        $data['symbol'] = $this->helper->getCurrentCurrencySymbol();
        $data['shareLink'] = url('/') . '/' . 'properties/' . $data['activity_id'];

        $data['date_format'] = Settings::getAll()->firstWhere('name', 'date_format_type')->value;

        // return $data;
        return view('activity.single', $data);
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
        $photos  = ActivityPhotos::find($request->photo_id);
        $photos->message = $request->messages;
        $photos->save();

        return json_encode(['success' => 'true']);
    }

    public function photoDelete(Request $request)
    {
        $photo   = ActivityPhotos::find($request->photo_id);
        $path = public_path('images/activity/' . $photo->activity_id . '/');
        if (file_exists($path . $photo->photo)) {
            @unlink($path . $photo->photo);
        }
        $photo->delete();

        return json_encode(['success' => 'true']);
    }

    public function makeDefaultPhoto(Request $request)
    {
        if ($request->option_value == 'Yes') {
            ActivityPhotos::where('activity_id', '=', $request->property_id)
                ->update(['cover_photo' => 0]);

            $photos = ActivityPhotos::find($request->photo_id);
            $photos->cover_photo = 1;
            $photos->save();
        }
        return json_encode(['success' => 'true']);
    }

    public function makePhotoSerial(Request $request)
    {

        $photos         = ActivityPhotos::find($request->id);
        $photos->serial = $request->serial;
        $photos->save();

        return json_encode(['success' => 'true']);
    }


    public function set_slug()
    {

        $properties   = Activity::where('slug', NULL)->get();
        foreach ($properties as $key => $activity) {

            $activity->slug     = $this->helper->pretty_url($activity->name);
            $activity->save();
        }
        return redirect('/');
    }

    public function userBookmark()
    {

        $data['bookings'] = Favourite::with(['properties' => function ($q) {
            $q->with('activity_address');
        }])->where(['user_id' => Auth::id(), 'status' => 'Active'])->orderBy('id', 'desc')
            ->paginate(Settings::getAll()->where('name', 'row_per_page')->first()->value);
        return view('users.favourite', $data);
    }

    public function addEditBookMark()
    {
        $activity_id = request('id');
        $user_id = request('user_id');

        $favourite = Favourite::where('activity_id', $activity_id)->where('user_id', $user_id)->first();

        if (empty($favourite)) {
            $favourite = Favourite::create([
                'activity_id' => $activity_id,
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
