<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{
    //
    public function index(Request $request)
    {
        return City::where('plan_id',$request->get('plan_id'))->get();

    }
    public function create(Request $request)
    {
        $city = City::create([

            'id' => $request->get('id'),
            'city_name' => $request->get('city_name'),

        ]);

    }
}
