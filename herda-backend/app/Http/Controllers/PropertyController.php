<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::query();
        // dump($request->city);
        if ($request->has('featured') && $request->featured === 'true') {
            $query->where('featured', 1)->limit(8);
        }

        if ($request->city) {
            // $query->where('location', 'like', '%' . $request->city . '%');
            // $query->whereRaw('? LIKE CONCAT("%", location, "%")', [$request->city]);
            $query->where('city', 'like', '%' . $request->city . '%')
            ->orWhereRaw('? LIKE CONCAT("%", city, "%")', [$request->city]);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->priceMin) {
            $query->where('price', '>=', $request->priceMin);
        }

        if ($request->priceMax) {
            $query->where('price', '<=', $request->priceMax);
        }

        // 🌐 Polygon filter (lat/lng within polygon)
        if ($request->filled('polygon')) {
            $polygon = json_decode($request->polygon, true);

            if (is_array($polygon)) {
                $query->whereRaw($this->buildPolygonWhereClause($polygon));
            }
        }

        return response()->json($query->latest()->get());
    }


    private function buildPolygonWhereClause(array $polygon): string
    {
        $points = array_map(function ($coord) {
            return $coord[1] . ' ' . $coord[0]; // lat lng
        }, $polygon);

        // Ensure polygon is closed
        if ($points[0] !== end($points)) {
            $points[] = $points[0];
        }

        $polygonWKT = 'POLYGON((' . implode(',', $points) . '))';

        return "ST_Contains(ST_GeomFromText('$polygonWKT'), POINT(latitude, longitude))";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function similar(Request $request)
    {
        $city = $request->query('city');
        $excludeId = $request->query('exclude');

        $properties = Property::with('media') // if using Spatie Media Library
            ->where('city', $city)
            ->where('id', '!=', $excludeId)
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'slug' => $property->slug,
                    'name' => $property->name,
                    'city' => $property->city,
                    'price' => $property->price,
                    'cover_image_url' => $property->getFirstMediaUrl('cover', 'thumb') ?? '/placeholder.jpg',
                ];
            });

        return response()->json($properties);
    }


}
