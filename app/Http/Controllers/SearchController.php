<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\{
    Activity,
    Properties,
    Settings,
    SpaceType,
    PropertyType,
    Amenities,
    AmenityType,
    Currency,
    PropertyDates,
    PropertyAddress
};

class SearchController extends Controller
{
    private $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index(Request $request)
    {
        $location = $request->input('location');
        // $address = str_replace(" ", "+", "$location");
        // $map_where = 'https://maps.google.com/maps/api/geocode/json?key=' . MAP_KEY . '&address=' . $address . '&sensor=false';
        // $geocode = $this->content_read($map_where);
        // $json = json_decode($geocode);

        // if ($json->{'results'}) {
        //     $data['lat'] = isset($json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}) ? $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'} : 0;
        //     $data['long'] = isset($json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}) ? $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'} : 0;
        // } else {
        $data['lat'] = 33.6844;
        $data['long'] = 73.0479;
        // }

        $data['location'] = $request->input('location');
        $data['checkin'] = $request->input('checkin');
        $data['checkout'] = $request->input('checkout');
        $data['guest'] = $request->input('guest');
        $data['category'] = $request->input('category');
        $data['bedrooms'] = $request->bedrooms ?? $request->min_bedrooms;
        $data['beds'] = $request->beds ?? $request->min_beds;
        $data['bathrooms'] = $request->bathrooms ?? $request->min_bathrooms;
        $data['min_price'] = $request->input('min_price');
        $data['max_price'] = $request->input('max_price');

        $data['space_type'] = SpaceType::getAll()->where('status', 'Active')->pluck('name', 'id');
        $data['property_type'] = PropertyType::getAll()->where('status', 'Active')->pluck('name', 'id');
        $data['amenities'] = Amenities::where('status', 'Active')->get();
        $data['amenities_type'] = AmenityType::pluck('name', 'id');

        $data['property_type_selected'] = !is_array($request->property_type) ? explode(',', $request->property_type) : $request->property_type;
        $data['space_type_selected'] = !is_array($request->space_type) ? explode(',', $request->space_type) : $request->space_type;
        $data['amenities_selected'] = !is_array($request->amenities) ? explode(',', $request->amenities) : $request->amenities;
        $currency = Currency::getAll();
        if (Session::get('currency')) $data['currency_symbol'] = $currency->firstWhere('code', Session::get('currency'))->symbol;
        else $data['currency_symbol'] = $currency->firstWhere('default', 1)->symbol;
        $minPrice = Settings::getAll()->where('name', 'min_search_price')->first()->value;
        $maxPrice = Settings::getAll()->where('name', 'max_search_price')->first()->value;
        $data['default_min_price'] = $this->helper->convert_currency(Currency::getAll()->firstWhere('default')->code, '', $minPrice);
        $data['default_max_price'] = $this->helper->convert_currency(Currency::getAll()->firstWhere('default')->code, '', $maxPrice);
        if (!$data['min_price']) {
            $data['min_price'] = $data['default_min_price'];
            $data['max_price'] = $data['default_max_price'];
        }
        $data['date_format'] = Settings::getAll()->firstWhere('name', 'date_format_type')->value;

        return view('search.view', $data);
    }

    function searchResult(Request $request)
    {
        $full_address = $request->input('location');
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $guest = $request->input('guest');
        $bedrooms = $request->input('bedrooms');
        $beds = $request->input('beds');
        $bathrooms = $request->input('bathrooms');
        $category = $request->input('category');
        $property_type = $request->input('property_type');
        $space_type = $request->input('space_type');
        $amenities = $request->input('amenities');
        $book_type = $request->input('book_type');
        $map_details = $request->input('map_details');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        if (!is_array($property_type)) {
            if ($property_type != '') {
                $property_type = explode(',', $property_type);
            } else {
                $property_type = [];
            }
        }

        if (!is_array($space_type)) {
            if ($space_type != '') {
                $space_type = explode(',', $space_type);
            } else {
                $space_type = [];
            }
        }

        if (!is_array($book_type)) {
            if ($book_type != '') {
                $book_type = explode(',', $book_type);
            } else {
                $book_type = [];
            }
        }
        if (!is_array($amenities)) {
            if ($amenities != '') {
                $amenities = explode(',', $amenities);
            } else {
                $amenities = [];
            }
        }

        $property_type_val = [];
        $properties_whereIn = [];
        $space_type_val = [];
        $minLat = '';
        $minLong = '';
        $maxLat = '';
        $maxLong = '';

        // $address = str_replace([" ", "%2C"], ["+", ","], "$full_address");
        // $map_where = 'https://maps.google.com/maps/api/geocode/json?key=' . MAP_KEY . '&address=' . $address . '&sensor=false&libraries=places';
        // $geocode = $this->content_read($map_where);
        // $json = json_decode($geocode);

        // if ($map_details != '') {
        //     $map_data = explode('~', $map_details);
        //     $minLat = $map_data[2];
        //     $minLong = $map_data[3];
        //     $maxLat = $map_data[4];
        //     $maxLong = $map_data[5];
        // } else {
        //     if ($json->{'results'}) {
        //         $data['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        //         $data['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

        //         $minLat = $data['lat'] - 0.35;
        //         $maxLat = $data['lat'] + 0.35;
        //         $minLong = $data['long'] - 0.35;
        //         $maxLong = $data['long'] + 0.35;
        //     } else {
        //         $data['lat'] = 0;
        //         $data['long'] = 0;

        //         $minLat = -1100;
        //         $maxLat = 1100;
        //         $minLong = -1100;
        //         $maxLong = 1100;
        //     }
        // }

        $users_where['users.status'] = 'Active';

        $checkin = date('Y-m-d', strtotime($checkin));
        $checkout = date('Y-m-d', strtotime($checkout));

        $days = $this->helper->get_days($checkin, $checkout);
        unset($days[count($days) - 1]);

        $calendar_where['date'] = $days;

        $not_available_property_ids = PropertyDates::whereIn('date', $days)->where('status', 'Not available')->distinct()->pluck('property_id');
        $properties_where['properties.accommodates'] = $guest;

        $properties_where['properties.status'] = 'Listed';

        if ($bedrooms) {
            $properties_where['properties.bedrooms'] = $bedrooms;
        }

        if ($bathrooms) {
            $properties_where['properties.bathrooms'] = $bathrooms;
        }

        if ($beds) {
            $properties_where['properties.beds'] = $beds;
        }

        if (count($space_type)) {
            foreach ($space_type as $space_value) {
                array_push($space_type_val, $space_value);
            }
            $properties_whereIn['properties.space_type'] = $space_type_val;
        }

        if (count($property_type)) {
            foreach ($property_type as $property_value) {
                array_push($property_type_val, $property_value);
            }

            $properties_whereIn['properties.property_type'] = $property_type_val;
        }

        $currency_rate = Currency::where('code', Session::get('currency'))->first()->rate;


        $properties = [];


        if ($category != 'activities') {
            $properties = Properties::with([
                'property_address',
                'property_price',
                'users'
            ])
                ->where('approved', 1)
                ->whereHas('property_price', function ($query) use ($min_price, $max_price, $currency_rate) {
                    $query->join('currency', 'currency.code', '=', 'property_price.currency_code');
                    $query->whereRaw('((price / currency.rate) * ' . $currency_rate . ') >= ' . $min_price . ' and ((price / currency.rate) * ' . $currency_rate . ') <= ' . $max_price);
                })
                ->whereHas('users', function ($query) use ($users_where) {
                    $query->where($users_where);
                })
                ->whereNotIn('id', $not_available_property_ids);
            // ->when($guest, function ($builder, $guest) {
            //     return $builder->where('properties.accommodates', $guest);
            // });


            if ($full_address) {
                $properties = $properties->whereHas('property_address', function ($query) use ($minLat, $maxLat, $minLong, $maxLong, $full_address) {
                    $query->where('address_line_1', 'LIKE', '%' . htmlentities($full_address) . '%');
                    // $query->whereRaw("latitude between $minLat and $maxLat and longitude between $minLong and $maxLong");
                });
            }
        } else {
            $properties = Activity::with([
                'address',
                'price',
                'user'
            ])
                ->where('approved', 1)
                ->whereHas('price', function ($query) use ($min_price, $max_price, $currency_rate) {
                    $query->join('currency', 'currency.code', '=', 'activity_prices.currency_code');
                    $query->whereRaw('((price / currency.rate) * ' . $currency_rate . ') >= ' . $min_price . ' and ((price / currency.rate) * ' . $currency_rate . ') <= ' . $max_price);
                })
                ->whereHas('user', function ($query) use ($users_where) {
                    $query->where($users_where);
                })
                ->whereNotIn('id', $not_available_property_ids);
            if ($full_address) {
                $properties = $properties->whereHas('address', function ($query) use ($minLat, $maxLat, $minLong, $maxLong, $full_address) {
                    $query->where('address_line_1', 'LIKE', '%' . htmlentities($full_address) . '%');
                    // $query->whereRaw("latitude between $minLat and $maxLat and longitude between $minLong and $maxLong");
                });
            }
        }



        if ($properties_where && $category != 'activities') {
            foreach ($properties_where as $row => $value) {
                if ($row == 'properties.accommodates' || $row == 'properties.bathrooms' || $row == 'properties.bedrooms' || $row == 'properties.beds') {
                    $operator = '>=';
                } else {
                    $operator = '=';
                }

                if ($value == '') {
                    $value = 0;
                }

                $properties = $properties->where($row, $operator, $value);
            }
        }

        if ($category && $category != 'activities') {
            $properties = $properties->where('category', $category);
        }

        if ($properties_whereIn) {
            foreach ($properties_whereIn as $row_properties_whereIn => $value_properties_whereIn) {
                $properties = $properties->whereIn($row_properties_whereIn, array_values($value_properties_whereIn));
            }
        }

        if (count($amenities)) {
            foreach ($amenities as $amenities_value) {
                $properties = $properties->whereRaw('find_in_set(' . $amenities_value . ', amenities)');
            }
        }

        if (count($book_type) && count($book_type) != 2) {
            foreach ($book_type as $book_value) {
                $properties = $properties->where('booking_type', $book_value);
            }
        }

        $properties = $properties->paginate(Session::get('row_per_page'))->toJson();

        // dd($properties);

        echo $properties;
    }

    public function content_read($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
