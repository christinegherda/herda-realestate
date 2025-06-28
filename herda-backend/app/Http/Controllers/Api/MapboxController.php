<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class MapboxController extends Controller
{
    public function suggest(Request $request)
    {
        $query = $request->input('q');
        if (!$query) {
            return response()->json(['error' => 'Missing query parameter.'], 400);
        }

        $response = Http::get("https://api.mapbox.com/geocoding/v5/mapbox.places/{$query}.json", [
            'access_token' => config('services.mapbox.access_token'),
            'autocomplete' => true,
            'limit' => 5,
            'types' => 'place,locality,region,country'
        ]);

        return response()->json($response->json());
    }
}

