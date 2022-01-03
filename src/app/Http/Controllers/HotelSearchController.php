<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HotelSearchController extends Controller
{
    public function index()
    {
        $url = "https://app.rakuten.co.jp/services/api/Travel/SimpleHotelSearch/20170426?applicationId=1051466363713368918&format=json&largeClassCode=japan&middleClassCode=akita&smallClassCode=tazawa";
        $method = "GET";

        //接続
        $client = new Client();

        $response = $client->request($method, $url);

        $posts = $response->getBody();
        $posts = json_decode($posts, true);
        $hotels = $posts["hotels"];

        return view('search.result', compact('hotels'));
    }
}
