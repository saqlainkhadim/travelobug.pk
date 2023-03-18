<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActivityAmenity extends Model
{
    public static function aminities($activityId)
    {
        $result = DB::select("select activity_amenities.title as title, activity_amenities.id as id, activity_amenities.symbol, activities.id as status from activity_amenities left join activities on find_in_set(activity_amenities.id, activities.amenities) and activities.id = $activityId");
        return $result;
    }
}
