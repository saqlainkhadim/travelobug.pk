<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SettingAddressesDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StartingCities;
use App\Http\Helpers\Common;
use Illuminate\Support\Facades\Validator;

class StartingCitiesController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index(SettingAddressesDataTable $dataTable)
    {
        return $dataTable->render('admin.startingCities.view');
    }


    public function add(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('admin.startingCities.add');
        } elseif ($request->isMethod('post')) {
            $rules = array('name' => 'required|max:100');

            $fieldNames = array('name' => 'Starting City Name');

            $validator = Validator::make($request->all(), $rules, [], $fieldNames);


            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {

                $starting_cities = new StartingCities;

                $starting_cities->name  = $request->name;
                $starting_cities->latitude  = $request->latitude;
                $starting_cities->longitude  = $request->longitude;

                $starting_cities->save();

                $this->helper->vrCacheForget('vr-cities');

                $this->helper->one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/addresses');
            }
        } else {
            return redirect('admin/settings/addresses');
        }
    }

    public function update(Request $request)
    {
        if (!$request->isMethod('post')) {
            $data['result'] = StartingCities::find($request->id);

            return view('admin.startingCities.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array('name'    => 'required|max:100');
            $fieldNames = array('name'    => 'Starting City Name');
            $validator = Validator::make($request->all(), $rules, [], $fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $starting_cities = StartingCities::find($request->id);

                $starting_cities->name  = $request->name;
                $starting_cities->latitude  = $request->latitude;
                $starting_cities->longitude  = $request->longitude;


                $starting_cities->save();

                $this->helper->vrCacheForget('vr-cities');

                $this->helper->one_time_message('success', 'Updated Successfully');
                return redirect('admin/settings/addresses');
            }
        } else {
            return redirect('admin/settings/addresses');
        }
    }

    public function delete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            $starting_cities = StartingCities::find($request->id);
            $file_path       = public_path() . '/front/images/starting_cities/' . $starting_cities->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            StartingCities::find($request->id)->delete();

            $this->helper->vrCacheForget('vr-cities');

            $this->helper->one_time_message('success', 'Deleted Successfully');
        }

        return redirect('admin/settings/addresses');
    }
}
