<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCities($province_id)
    {
        $cities = City::where('province_id', $province_id)->get();
        return response()->json($cities);
    }
}