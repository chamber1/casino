<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\RestaurantImage;

class ApiRestarauntController extends Controller
{
    public function restaurants(Request $request) {

        $restaurants = Restaurant::all()->toArray();
        
        return response()->json($restaurants);
    }
    
    public function restaurant(Request $request) {

        $restaurant = Restaurant::find($request->id)->toArray();
        
        return response()->json($restaurant);
    }
    
    public function menuImages(Request $request) {

        $restaurant_menu_images = RestaurantImage::where('restaurant_id','=',$request->restaurantId)->get()->toArray();
        
        return response()->json($restaurant_menu_images);
    }
}
