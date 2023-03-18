<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ActivityTypeDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use Illuminate\Support\Facades\Cache;
use App\Http\Helpers\Common;
use Illuminate\Support\Facades\Validator;

class ActivityTypeController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index(ActivityTypeDataTable $dataTable)
    {
        return $dataTable->render('admin.activities.type.view');
    }

    public function add(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('admin.activities.type.add');
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name'           => 'required|max:100',
                'description'    => 'required|max:255',
                'status'         => 'required'
            );

            $fieldNames = array(
                'name'              => 'Name',
                'description'       => 'Description',
                'status'            => 'Status'
            );

            $validator = Validator::make($request->all(), $rules, [], $fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $activityType                = new ActivityType;
                $activityType->name          = $request->name;
                $activityType->description   = $request->description;
                $activityType->status        = $request->status;
                $activityType->save();
                Cache::forget(config('cache.prefix') . '.activity.types.activity');
                $this->helper->one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/activity-type');
            }
        }
    }

    public function update(Request $request)
    {
        if (!$request->isMethod('post')) {
            $data['result'] = ActivityType::find($request->id);

            return view('admin.activities.type.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name'           => 'required|max:110',
                'description'    => 'required|max:255',
                'status'         => 'required'
            );

            $fieldNames = array(
                'name'              => 'Name',
                'description'       => 'Description',
                'status'            => 'Status'
            );
            $validator = Validator::make($request->all(), $rules, [], $fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $activityType  = ActivityType::find($request->id);

                $activityType->name          = $request->name;
                $activityType->description   = $request->description;
                $activityType->status        = $request->status;
                $activityType->save();

                Cache::forget(config('cache.prefix') . '.activity.types.activity');
                $this->helper->one_time_message('success', 'Updated Successfully');

                return redirect('admin/settings/activity-type');
            }
        }
    }

    public function delete(Request $request)
    {
        ActivityType::find($request->id)->delete();
        Cache::forget(config('cache.prefix') . '.activity.types.activity');
        $this->helper->one_time_message('success', 'Deleted Successfully');

        return redirect('admin/settings/activity-type');
    }
}
