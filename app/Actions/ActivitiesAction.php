<?php

namespace App\Actions;

use App\Http\Helpers\Common;
use App\Models\Activity;
use App\Models\ActivityAddress;
use App\Models\ActivityDescription;
use App\Models\ActivityStep;
use App\Models\PropertyAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivitiesAction
{
    protected $helper;
    protected $isAdmin;
    public function __construct($isAdmin = false)
    {
        $this->isAdmin = $isAdmin;
        $this->helper = new Common;
    }
    public function basic(Request $request, $activity_id)
    {
        $activity = Activity::find($activity_id);

        $activity->activity_type = $request->activity_type;
        $activity->recomended    = $request->recomended;
        $activity->save();

        $activity_steps = ActivityStep::where('activity_id', $activity_id)->first();
        if (!$activity_steps) {
            $activity_steps = new ActivityStep();
            $activity_steps->activity_id = $activity_id;
        }
        $activity_steps->basics = 1;
        $activity_steps->save();

        if ($this->isAdmin) {
            return redirect()->route('activity.listing', [$activity_id, 'description']);
        }

        return redirect()->route('user.activity.listing', [$activity_id, 'description']);
    }

    public function description(Request $request, $activity_id)
    {
        $rules = array(
            'name' => 'required|max:50',
            'summary' => 'required|max:1000'
        );
        $fieldNames = array(
            'name' => 'Name',
            'summary' => 'Summary'
        );

        $validator = Validator::make($request->all(), $rules, [], $fieldNames);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $activity = Activity::find($activity_id);

        $activity->name     = $request->name;
        $activity->slug     = $this->helper->pretty_url($request->name, Activity::class);
        $activity->save();

        $activity_description = ActivityDescription::where('activity_id', $activity_id)->first();

        $activity_description->summary     = $request->summary;
        $activity_description->save();

        $activity_steps = ActivityStep::where('activity_id', $activity_id)->first();
        $activity_steps->description = 1;
        $activity_steps->save();

        if ($this->isAdmin) {
            return redirect()->route('activity.listing', [$activity_id, 'location']);
        }
        return redirect()->route('user.activity.listing', [$activity_id, 'location']);
    }

    public function details(Request $request, $activity_id)
    {
        $activity_description = ActivityDescription::where('activity_id', $activity_id)->first();
        $activity_description->description = $request->description;
        $activity_description->save();

        if ($this->isAdmin) {
            return redirect()->route('activity.listing', [$activity_id, 'description']);
        }
        return redirect()->route('user.activity.listing', [$activity_id, 'description']);
    }

    public function location(Request $request, $activity_id)
    {
        $rules = array(
            'address_line_1'    => 'required|max:250',
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

        $validator = Validator::make($request->all(), $rules, $messages, [], $fieldNames);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $activity_address = ActivityAddress::where('activity_id', $activity_id)->first();

        $activity_address->address_line_1 = $request->address_line_1;
        $activity_address->address_line_2 = $request->address_line_2;
        $activity_address->latitude       = $request->latitude;
        $activity_address->longitude      = $request->longitude;
        $activity_address->city           = $request->city;
        $activity_address->state          = $request->state;
        $activity_address->country        = $request->country;
        $activity_address->postal_code    = $request->postal_code;
        $activity_address->save();

        if ($this->isAdmin) {
            Activity::find($activity_id)->update(['embeded_map' => $request->embeded_map]);
        }

        $activity_steps = ActivityStep::where('activity_id', $activity_id)->first();
        $activity_steps->location = 1;
        $activity_steps->save();

        if ($this->isAdmin) {
            return redirect()->route('activity.listing', [$activity_id, 'amenities']);
        }
        return redirect()->route('user.activity.listing', [$activity_id, 'amenities']);
    }

    public function amenities(Request $request, $activity_id)
    {
        if (is_array($request->amenities)) {
            $activity = Activity::find($request->id);
            $activity->amenities = implode(',', $request->amenities);
            $activity->save();
        }

        if ($this->isAdmin) {
            return redirect()->route('activity.listing', [$activity_id, 'photos']);
        }
        return redirect()->route('user.activity.listing', [$activity_id, 'photos']);
    }
}
