<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $hotels = empty($request->query()) ? null : $this->getHotels($request);
        $areas = $this->getAreas();

        return view('search.search', compact('hotels', 'areas'));
    }

    public function getHotels($request)
    {
        return $this->getData(
            env('SIMPLE_HOTEL_SEARCH_URL'),
            env('APPLICATION_ID'),
            env('FORMAT'),
            env('LARGE_CLASS_CODE'),
            $request,
        );
    }

    public function getAreas()
    {
        return $this->getData(
            env('AREA_URL'),
            env('APPLICATION_ID'),
            env('FORMAT'),
            null,
            null,
        );
    }

    public function getData($URL, $ID, $FORMAT, $L_CLASS, $request)
    {
        $apiUrl = $URL;
        $appId = $ID;
        $format = $FORMAT;
        $largeClass = $L_CLASS;
        $method = "GET";
        $isArea = fn($request) => is_null($request) && true;

        if ($isArea($request)) {
            $url = "{$apiUrl}?applicationId={$appId}&format={$format}";
        } else {
            $middleClass = $request->query('middle');
            $smallClass = $request->query('small');
            $url = "{$apiUrl}?applicationId={$appId}&format={$format}&largeClassCode={$largeClass}&middleClassCode={$middleClass}&smallClassCode={$smallClass}";
        }

        //接続
        $client = new Client();
        $response = $client->request($method, $url);
        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        $data = $isArea($request) ?
            $posts["areaClasses"]["largeClasses"][0]["largeClass"][1]["middleClasses"] :
            $posts["hotels"];

        return $data;
    }
}
