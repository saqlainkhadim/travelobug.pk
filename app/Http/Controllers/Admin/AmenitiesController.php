<?php

/**
 * Amenities Controller
 *
 * Amenities Controller manages Amenities by admin.
 *
 * @category   Amenities
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @email      support@techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\AmenitiesDataTable;
use App\Models\Amenities;
use App\Models\AmenityType;
use App\Http\Helpers\Common;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AmenitiesController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index(AmenitiesDataTable $dataTable)
    {
        return $dataTable->render('admin.amenities.view');
    }

    public function add(Request $request)
    {
        $info = $request->isMethod('post');
        if (!$info) {
            $amenity_type = AmenityType::get();
            $am = [];
            foreach ($amenity_type as $key => $value) {
                $am[$value->id] = $value->name;
            }
            $data['am'] = $am;
            return view('admin.amenities.add', $data);
        } elseif ($info) {
            $rules = array(
                'title'       => 'required|max:50',
                'description' => 'required|max:100',
                'symbol'      => 'required|file|mimes:png,svg|max:128',
                'type_id'     => 'required',
                'status'      => 'required'
            );

            $fieldNames = array(
                'title'       => 'Title',
                'description' => 'Description',
                'symbol'      => 'Symbol'
            );

            $validator = Validator::make($request->all(), $rules, [], $fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $amenity = new Amenities;
                $amenity->title       = $request->title;
                $amenity->description = $request->description;

                if ($request->hasFile('symbol')) {
                    $amenity_path = uniqid('amenity_') . '.' . $request->file('symbol')->getClientOriginalExtension();
                    $request->file('symbol')->move(public_path('images/symbols'), $amenity_path);
                    $amenity->symbol = $amenity_path;
                }

                $amenity->type_id     = $request->type_id;
                $amenity->status      = $request->status;
                $amenity->save();

                $this->helper->one_time_message('success', 'Added Successfully');
                return redirect('admin/amenities');
            }
        }
    }
    public function update(Request $request)
    {
        $info = $request->isMethod('post');
        if (!$info) {
            $amenity_type = AmenityType::get();
            $am = [];
            foreach ($amenity_type as $key => $value) {
                $am[$value->id] = $value->name;
            }
            $data['am']   = $am;
            $data['result'] = Amenities::find($request->id);
            return view('admin.amenities.edit', $data);
        } elseif ($info) {
            $rules = array(
                'title'          => 'required|max:50',
                'description'    => 'required|max:100',
                'symbol'         => 'nullable|file|mimes:png,svg|max:128',
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
                $amenity = Amenities::find($request->id);
                $amenity->title       = $request->title;
                $amenity->description = $request->description;

                $old_symbol = $amenity->symbol;
                if ($request->hasFile('symbol')) {
                    $activity_amenity = uniqid('amenity_') . '.' . $request->file('symbol')->getClientOriginalExtension();
                    $request->file('symbol')->move(public_path('images/symbols'), $activity_amenity);
                    $amenity->symbol = $activity_amenity;
                    if (File::exists(public_path('images/symbols/' . $old_symbol))) {
                        @File::delete(public_path('images/symbols/' . $old_symbol));
                    }
                }

                $amenity->type_id     = $request->type_id;
                $amenity->status      = $request->status;
                $amenity->save();

                $this->helper->one_time_message('success', 'Updated Successfully');
                return redirect('admin/amenities');
            }
        }
    }

    public function delete(Request $request)
    {
        Amenities::find($request->id)->delete();
        $this->helper->one_time_message('success', 'Deleted Successfully');
        return redirect('admin/amenities');
    }
}
