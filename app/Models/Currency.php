<?php

/**
 * Currency Model
 *
 * Currency Model manages Currency operation.
 *
 * @category   Currency
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @since      Version 1.3
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Currency extends Model
{
    protected $table   = 'currency';
    public $timestamps = false;

    protected $appends = ['org_symbol'];


    public static function code_to_symbol($code)
    {
        return self::getAll()->firstWhere('code', $code)->symbol;
    }

    public function getOrgSymbolAttribute()
    {
        $symbol = $this->attributes['symbol'];
        return $symbol;
    }

    public function getSessionCodeAttribute()
    {
        if (Session::get('currency')) {
            return Session::get('currency');
        } else {
            return self::getAll()->firstWhere('default', 1)->code;
        }
    }

    public static function getAll()
    {
        $data = Cache::get(config('cache.prefix') . '.currency');
        if (empty($data)) {
            $data = parent::all();
            Cache::put(config('cache.prefix') . '.currency', $data, 30 * 86400);
        }
        if (!array_key_exists(Session::get('currency'), $data->pluck('code', 'code')->toArray())) {
            Session::put('currency', $data->where('status', 'Active')->firstWhere('default', 1)->code);
        }
        return $data;
    }
}
