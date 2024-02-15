<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return response()->json($locations);
    }

    public function show($locationId)
    {
        $location = Location::find($locationId);

        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        return response()->json($location);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:locations',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location = Location::create($request->json()->all());

        return response()->json($location, 201);
    }

    public function update(Request $request, $locationId)
    {
        $location = Location::find($locationId);

        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        $request->validate([
            'name' => 'string',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
        ]);

        try {
            $location->update($request->json()->all());
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }

        return response()->json($location);
    }

    public function destroy($locationId)
    {
        $location = Location::find($locationId);

        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }

        $location->delete();

        return response()->json(['message' => 'Location deleted successfully'], 202);
    }
}
