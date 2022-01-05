<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct()
    {
    }

    public function search(Request $request)
    {
//        $keyword = $request->input('keyword');
//        dd($keyword);
    }

    public function index(Request $request)
    {
//        if (!is_null($request)){
//            $keyword = $request->input('keyword');
//        }
//        $apiUrl = env('SIMPLE_HOTEL_SEARCH_URL');
//        $appId = env('APPLICATION_ID');
//        $format = env('FORMAT');
//        $largeClass = env('LARGE_CLASS_CODE');
//        $middleClass = $keyword;
//        $smallClass = $keyword;
//
//        $url = "{$apiUrl}?applicationId={$appId}&format={$format}&largeClassCode={$largeClass}&middleClassCode={$middleClass}";

        $searchUrl = "https://app.rakuten.co.jp/services/api/Travel/SimpleHotelSearch/20170426?applicationId=1051466363713368918&format=json&largeClassCode=japan&middleClassCode=akita&smallClassCode=tazawa";
        $areaUrl = "https://app.rakuten.co.jp/services/api/Travel/GetAreaClass/20131024?applicationId=1051466363713368918&format=json";
        $method = "GET";

        //接続
        $client = new Client();

        $searchResponse = $client->request($method, $searchUrl);
        $areaResponse = $client->request($method, $areaUrl);

        $searchPosts = $searchResponse->getBody();
        $searchPosts = json_decode($searchPosts, true);
        $hotels = $searchPosts["hotels"];

        $areaPosts = $areaResponse->getBody();
        $areaPosts = json_decode($areaPosts, true);
        $areas = $areaPosts["areaClasses"]["largeClasses"][0]["largeClass"][1]["middleClasses"];

//        dd($areas);
        return view('search.result', compact('hotels', 'areas'));
    }

    public function getArea(Request $request)
    {
        dd($request);
        if (!is_null($request)){
            $keyword = $request->input('keyword');
        }
        $apiUrl = env('SIMPLE_HOTEL_SEARCH_URL');
        $appId = env('APPLICATION_ID');
        $format = env('FORMAT');
        $largeClass = env('LARGE_CLASS_CODE');
        $middleClass = $keyword;
        $smallClass = $keyword;

        $url = "{$apiUrl}?applicationId={$appId}&format={$format}&largeClassCode={$largeClass}&middleClassCode={$middleClass}";
        $method = "GET";

        //接続
        $client = new Client();

        $searchResponse = $client->request($method, $searchUrl);

        $searchPosts = $searchResponse->getBody();
        $searchPosts = json_decode($searchPosts, true);
        $hotels = $searchPosts["hotels"];

        return view('search.result', compact('hotels'));
    }
}
