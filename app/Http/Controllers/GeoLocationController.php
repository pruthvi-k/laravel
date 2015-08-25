<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GeoLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('map');
    }

    /**
     * AJAX REQUEST
     * Save location's latitude and longitude in db
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Controllers\Response
     */
    public function create(Request $request)
    {
        $geoLocationData = [
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'location_type' => is_null($request->input('location_type'))?'':$request->input('location_type'),
            'address' => $request->input('address')
        ];

        $geoLocation = DB::table('geo_location')->insert($geoLocationData);
    }
}
