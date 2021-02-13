<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PokerClub;
use App\Http\Controllers\Controller;

class ApiPokerClubController extends Controller
{
    public function all(Request $request) {

        $clubs = PokerClub::all()->toArray();
        
        return response()->json($clubs);
    }
    
    public function pokerClub(Request $request) {

        $club = PokerClub::find($request->id)->toArray();

        return response()->json($club);
    }
    
}
