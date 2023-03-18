<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ActivitiesAction;
use App\DataTables\ActivitiesAddRequestsDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\PropertiesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Helpers\Common;
use App\Http\Controllers\Admin\CalendarController;
use App\DataTables\ActivitiesDataTable;

use App\Models\{Activity, ActivityAddress, ActivityAmenity, ActivityDescription, ActivityPrice, ActivityStep, ActivityType, ActivityPhotos, Currency, Country, Amenities, User, Settings, Bookings};
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class ActivitiesController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function addRequests(ActivitiesAddRequestsDataTable $dataTable)
    {
        return $dataTable->render('admin.activities.add-requests');
    }

    public function requestApprove($id)
    {
        $property = Activity::findOrFail($id);
        $property->approved = 1;
        $property->save();

        $this->helper->one_time_message('success', 'Requested activity is approved');
        return back();
    }

    public function requestReject($id)
    {
        $property = Activity::findOrFail($id);
        $property->approved = 2;
        $property->save();

        $this->helper->one_time_message('success', 'Requested activity is approved');
        return back();
    }

    public function index(ActivitiesDataTable $dataTable)
    {
        $data['from'] = isset(request()->from) ? request()->from : null;
        $data['to']   = isset(request()->to) ? request()->to : null;

        if (isset(request()->reset_btn)) {
            $data['from']        = null;
            $data['to']          = null;
            $data['allstatus']   = '';
            return $dataTable->render('admin.activities.view', $data);
        }
        isset(request()->status) ? $data['allstatus'] = $allstatus = request()->status : $data['allstatus'] = $allstatus = '';
        return $dataTable->render('admin.activities.view', $data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'activity_name' => 'required',
                'activity_type_id' => 'required',
                'map_address'       => 'required',
                'host_id'           => 'required',
                'what_you_do'           => 'required',
                'what_include'           => 'required',
            );

            $fieldNames = array(
                'activity_name'  => 'Activity Name',
                'activity_type_id'  => 'Activity Type',
                'map_address'       => 'City',
                'host_id'           => 'Host',
                'what_you_do'           => 'What you will do',
                'what_include'           => 'What includes',
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
            $activity->what_you_do      = $request->what_you_do;
            $activity->what_include      = $request->what_include;
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

            return redirect()->route('activity.listing', [$activity->id, 'basics']);
        }

        $data['users']         = User::where('status', 'Active')->get();
        $data['activityTypes'] = ActivityType::where('status', 'Active')->pluck('name', 'id');
        return view('admin.activities.add', $data);
    }

    public function listing(Request $request, CalendarController $calendar)
    {
        $step            = $request->step;
        $activity_id     = $request->id;

        $action = new ActivitiesAction(true);

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
                    // $data['result']->update(['embeded_map' => $request->embeded_map]);
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
                        'file' => Rule::dimensions(['min_width' => 640, 'min_height' => 360])
                    ]);

                    if ($validate->fails()) {
                        return back()->withErrors($validate)->withInput();
                    }

                    $path = public_path('images/activity/' . $activity_id . '/');

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
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

                    return redirect()->route('activity.listing', [$activity_id, 'photos'])->with('success', 'File Uploaded Successfully!');
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

                    return redirect(route('activity.listing', [$activity_id, 'booking']));
                }
                break;
            case 'booking':
                if ($request->isMethod('post')) {
                    $activity = Activity::find($activity_id);
                    $activity->booking_type = $request->booking_type;
                    $activity->status       = 'Listed';
                    $activity->approved       = 1;
                    $activity->save();

                    $activity_steps          = ActivityStep::where('activity_id', $activity_id)->first();
                    $activity_steps->booking = 1;
                    $activity_steps->save();

                    return redirect(route('activity.listing', [$activity_id, 'calender']));
                }
                break;
        }

        if ($step == 'calender') {
            $data['calendar'] = $calendar->generateForActivity($request->id);
        }

        return view("admin.activities.listing.$step", $data);
    }

    public function update(Request $request)
    {
        if (!$request->isMethod('post')) {
            $data['result'] = ActivityAmenity::find($request->id);
            return view('admin.amenities.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'title'          => 'required',
                'description'    => 'required',
                'symbol'         => 'required',
                'type_id'        => 'required',
                'status'         => 'required'
            );

            $fieldNames = array(
                'title'             => 'Title',
                'description'       => 'Description',
                'symbol'            => 'Symbol'
            );

            $validator = Validator::make($request->all(), $rules, [], $fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $amenitie = ActivityAmenity::find($request->id);
                $amenitie->title          = $request->title;
                $amenitie->description    = $request->description;
                $amenitie->symbol         = $request->symbol;
                $amenitie->type_id        = $request->type_id;
                $amenitie->status         = $request->status;
                $amenitie->save();

                $this->helper->one_time_message('success', 'Updated Successfully');
                return redirect()->route('activity.index');
            }
        }
    }

    public function delete(Request $request)
    {
        $bookings   = Bookings::where(['property_id' => $request->id])->get()->toArray();
        if (env('APP_MODE', '') != 'test') {
            if (count($bookings) > 0) {
                $this->helper->one_time_message('danger', 'This activity has Bookings. Sorry can not possible to delete');
            } else {
                Activity::find($request->id)->delete();
                $this->helper->one_time_message('success', 'Deleted Successfully');
                return redirect(route('activity.index'));
            }
        }
        return redirect(route('activity.index'));
    }

    public function photoMessage(Request $request)
    {
        $activity = Activity::find($request->id);
        $photos  = ActivityPhotos::find($request->photo_id);
        $photos->message = $request->messages;
        $photos->save();

        return json_encode(['success' => 'true']);
    }

    public function photoDelete(Request $request)
    {
        $photo = ActivityPhotos::find($request->photo_id);
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

    public function propertyCsv($id = null)
    {
        return Excel::download(new PropertiesExport, 'activities_sheet' . time() . '.xls');
    }

    public function propertyPdf($id = null)
    {
        $to                 = setDateForDb(request()->to);
        $from               = setDateForDb(request()->from);
        $data['companyLogo']  = $logo  = Settings::getAll()->where('name', 'logo')->first()->value;
        if (is_null($logo) || $logo == '') {
            $data['logo_flag'] = 0;
        } elseif (!file_exists("public/front/images/logos/$logo")) {
            $data['logo_flag'] = 0;
        }
        $data['status']     = $status = isset(request()->status) ? request()->status : null;
        $activities = $this->getAllProperties();

        if (isset($id)) {
            $activities->where('activities.host_id', '=', $id);
        }

        if ($from) {
            $activities->whereDate('activities.created_at', '>=', $from);
        }

        if ($to) {
            $activities->whereDate('activities.created_at', '<=', $to);
        }

        if (!is_null($status)) {
            $activities->where('activities.status', '=', $status);
        }

        $data['propertyList'] = $activities->get();

        if ($from && $to) {
            $data['date_range'] = onlyFormat($from) . ' To ' . onlyFormat($to);
        }


        $pdf = Pdf::loadView('admin.activities.list_pdf', $data, [], [
            'format' => 'A3', [750, 1060]
        ]);
        return $pdf->download('property_list_' . time() . '.pdf', array("Attachment" => 0));
    }

    public function getAllProperties()
    {
        $query = Activity::join('users', function ($join) {
            $join->on('users.id', '=', 'activities.host_id');
        })->select([
            'activities.id as activities_id',
            'activities.name as property_name',
            'activities.status as property_status',
            'activities.created_at as property_created_at',
            'activities.updated_at as property_updated_at',
            'activities.*',
            'users.*',
        ])
            ->orderBy('activities.id', 'desc');
        return $query;
    }

    public function approvedStatus($id)
    {
        Activity::where('id', $id)->update(['approved' => 1]);
        $this->helper->one_time_message('success', 'Approved Successfully');
        return back();
    }
}
