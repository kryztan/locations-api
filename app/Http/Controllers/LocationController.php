<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    /**
     * Gets a list of the locations that fall within the given radius of the given coordinates
     *
     * @param Request $request
     * @queryParam latitude float required The latitude of the start point of the radius.
     * @queryParam longitude float required The longitude of the start point of the radius.
     * @queryParam radius int required The radius distance.
     * @queryParam radiusUnit string The unit of measurement of the radius, can either be "km" or "mi"
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|regex:/^-?\d*\.{0,17}\d+$/',
            'longitude' => 'required|regex:/^-?\d*\.{0,17}\d+$/',
            'radius' => 'required|integer|min:0',
            'radiusUnit' => [
                'sometimes',
                Rule::in(['km', 'mi']),
            ],
        ]);

        $locations = Location::withinRadius($validated['latitude'], $validated['longitude'], $validated['radius'], $validated['radiusUnit'] ?? 'km')->get();

        return LocationResource::collection($locations);
    }
}
