<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['host_name', 'cover_photo'];

    protected $guarded = ['id'];

    public static function recommendedActivities()
    {
        $data = parent::where('status', 'Listed')
            ->with('user', 'price', 'address')
            ->where('approved', 1)
            // ->where('recomended', '1')
            ->orderBy('recomended', 'desc')
            ->take(8)
            ->inRandomOrder()
            ->get();
        return $data;
    }

    // relations
    public function user()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function type()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type');
    }

    public function address()
    {
        return $this->hasOne(ActivityAddress::class);
    }

    public function description()
    {
        return $this->hasOne(ActivityDescription::class);
    }

    public function price()
    {
        return $this->hasOne(ActivityPrice::class);
    }

    public function amenities()
    {
        return $this->hasMany(ActivityAmenity::class);
    }

    public function dates()
    {
        return $this->hasMany(ActivityDate::class);
    }

    public function photos()
    {
        return $this->hasMany(ActivityPhotos::class);
    }

    public function rules()
    {
        return $this->hasMany(ActivityRules::class);
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }

    public function getHostNameAttribute()
    {
        $result = User::where('id', $this->attributes['host_id'])->first();
        return $result->first_name;
    }

    public function getHostImageAttribute()
    {
        $result = User::where('id', $this->attributes['host_id'])->first();
        return $result->profile_image;
    }

    public function getCoverPhotoAttribute()
    {
        $cover = ActivityPhotos::where('activity_id', $this->attributes['id'])->where('cover_photo', 1)->first();
        if (isset($cover->photo)) {
            $url = url('public/images/activity/' . $this->attributes['id'] . '/' . $cover->photo);
        } else {
            $url = url('public/images/default-image.png');
        }
        return $url;
    }
}
