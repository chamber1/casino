<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;







class ApiEventController extends Controller
{


    public function events(Request $request) {

        $events = Event::all()->toArray();
        
        return response()->json(['events' => $events]);
    }

    
}
