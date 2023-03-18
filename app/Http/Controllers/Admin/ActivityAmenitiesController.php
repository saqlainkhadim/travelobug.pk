<?php

/**
 * ActivityAmenity Controller
 *
 * ActivityAmenity Controller manages ActivityAmenity by admin.
 *
 * @category   ActivityAmenity
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @since      Version 1.3
 */

namespace App\Http\Controllers\Admin;

use App\DataTables\ActivityAmenitiesDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Models\ActivityAmenity;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ActivityAmenitiesController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index(ActivityAmenitiesDataTable $dataTable)
    {
        return $dataTable->render('admin.activities.amenities.view');
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'title'          => 'required|max:50',
                'description'    => 'required|max:100',
                'symbol'         => 'required|file|mimes:png,svg|max:128',
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
            }

            $amenity = new ActivityAmenity();

            $amenity->title       = $request->title;
            $amenity->description = $request->description;

            if ($request->hasFile('symbol')) {
                $activity_amenity = uniqid('act_amenity_') . '.' . $request->file('symbol')->getClientOriginalExtension();
                $request->file('symbol')->move(public_path('images/symbols'), $activity_amenity);
                $amenity->symbol = $activity_amenity;
            }

            $amenity->status      = $request->status;
            $amenity->save();

            $this->helper->one_time_message('success', 'Added Successfully');
            return redirect()->route('activity.amenities');
        }
        return view('admin.activities.amenities.add');
    }

    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'title'          => 'required|max:50',
                'description'    => 'required|max:100',
                'symbol'         => 'nullable|file|mimes:png,svg|max:128',
                'status'         => 'required'
            ];

            $fieldNames = [
                'title'             => 'Title',
                'description'       => 'Description',
                'symbol'            => 'Symbol'
            ];

            $validator = Validator::make($request->all(), $rules, [], $fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $amenity = ActivityAmenity::find($request->id);

            $amenity->title       = $request->title;
            $amenity->description = $request->description;

            $old_symbol = $amenity->symbol;
            if ($request->hasFile('symbol')) {
                $activity_amenity = uniqid('act_amenity_') . '.' . $request->file('symbol')->getClientOriginalExtension();
                $request->file('symbol')->move(public_path('images/symbols'), $activity_amenity);
                $amenity->symbol = $activity_amenity;
                if (File::exists(public_path('images/symbols/' . $old_symbol))) {
                    @File::delete(public_path('images/symbols/' . $old_symbol));
                }
            }

            $amenity->status = $request->status;
            $amenity->save();


            $this->helper->one_time_message('success', 'Updated Successfully');
            return redirect()->route('activity.amenities');
        }
        $data['result'] = ActivityAmenity::find($request->id);
        return view('admin.activities.amenities.edit', $data);
    }

    public function delete(Request $request)
    {
        ActivityAmenity::find($request->id)->delete();
        $this->helper->one_time_message('success', 'Deleted Successfully');
        return redirect()->route('activity.amenities');
    }
}
