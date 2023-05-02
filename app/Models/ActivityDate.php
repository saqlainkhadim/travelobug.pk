<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ActivityDate extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    public static function getTempDates()
    {
        $data = Cache::get(config('cache.prefix') . '.calc.activity_price');
        if (empty($data)) {
            $data = ActivityDate::all();
            Cache::put(config('cache.prefix') . '.calc.activity_price', $data, 30 * 86400);
        }
        return $data;
    }
}
