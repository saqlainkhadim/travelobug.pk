<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ActivityPrice extends Model
{
    use HasFactory;

    protected $appends = [
        'original_price',
        'default_code',
        'default_symbol'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public function getOriginalPriceAttribute()
    {
        return $this->attributes['price'];
    }


    public function getPriceAttribute()
    {
        return $this->currency_convert('price');
    }

    //Original Property Price
    public function original_price($date)
    {
        $result = ActivityDate::getTempDates()
            ->where('activity_id', $this->attributes['activity_id'])
            ->where('date', $date);

        try {
            return $result->first()->price;
        } catch (\Exception $e) {
            return $this->attributes['price'];
        }
    }

    public function price($date)
    {
        $where = ['activity_id' => $this->attributes['activity_id'], 'date' => $date];
        $result = ActivityDate::where($where);

        if ($result->count()) {
            return $result->first()->price;
        } else {
            return $this->currency_convert('price');
        }
    }


    public function available($date)
    {
        $result = ActivityDate::getTempDates()
            ->where('activity_id', $this->attributes['activity_id'])
            ->where('date', $date);
        try {
            return $result->first()->status;
        } catch (\Exception $e) {
            return 'Available';
        }
    }

    public function currency_convert($field)
    {
        $rate = Currency::where('code', $this->attributes['currency_code'])->firstOrFail()->rate;
        if ($rate == 0) {
            return 0;
        }

        $unit = $this->attributes[$field] / $rate;

        $default_currency = Currency::getAll()->firstWhere('default', 1)->code;

        $session_rate = Currency::getAll()->firstWhere('code', (Session::get('currency')) ? Session::get('currency') : $default_currency)->rate;

        return round($unit * $session_rate, 2);
    }

    public function getDefaultCodeAttribute()
    {
        if (Session::get('currency')) {
            return Session::get('currency');
        } else {
            return Currency::getAll()->firstWhere('default', 1)->code;
        }
    }

    public function getDefaultSymbolAttribute()
    {
        if (Session::get('currency')) {
            return Currency::getAll()->firstWhere('code', Session::get('currency'))->symbol;;
        } else {
            return Currency::getAll()->firstWhere('default', 1)->symbol;
        }
    }


    public function min_day($date)
    {
        $result = ActivityDate::getTempDates()
            ->where('activity_id', $this->attributes['activity_id'])
            ->where('date', $date);

        if ($result->count() > 0) {
            return $result->first()->min_day;
        } else {
            $min_day = 0;
            return $min_day;
        }
    }
}
