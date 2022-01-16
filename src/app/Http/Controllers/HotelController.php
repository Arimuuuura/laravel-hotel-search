<?php

namespace App\Http\Controllers;

use App\Services\RakutenApi\HotelSearch;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    private $hotelData;

    public function __construct()
    {
        $this->hotelData = new HotelSearch();
        $this->middleware('auth');

        $this->middleware(function($request, $next) {
//            dd($request, $next);
            $id = $request->route()->parameter('hotel');
            $info = $next;
//            if (!is_null($id)) {
//                $itemId = Product::availableItems()->where('products.id', $id)->exists();
//                if (!$itemId) {
//                    abort(404);
//                }
//            };
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $hotels = empty($request->query()) ? null : $this->hotelData->getHotels($request);
        $areas = $this->hotelData->getAreas();

        return view('search.search', compact('hotels', 'areas'));
    }

    public function show($id, $info)
    {
        dd($id, $info);
    }
}
