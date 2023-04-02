<?php

namespace Tests\Feature;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LocationTest extends TestCase
{
    /**
     * Gets all locations that fall within a radius of a random set of coordinates and tests if the response is in correct format.
     */
    public function test_get_locations_randomly(): void
    {
        $latitude = $this->generateRandomCoordinate(Location::min('latitude'), Location::max('latitude'));
        $longitude = $this->generateRandomCoordinate(Location::min('longitude'), Location::max('longitude'));
        $radius = rand(0, 1000);

        $response = $this->getJson("/api/locations?latitude=$latitude&longitude=$longitude&radius=$radius");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'name',
                            'latitude',
                            'longitude'
                        ]
                    ]
                ]
            );
    }

    /**
     * Specifically gets a random Location and tests if it's present, and the only row
     */
    public function test_get_random_location(): void
    {
        $location = Location::inRandomOrder()->first();

        $response = $this->getJson("/api/locations?latitude=$location->latitude&longitude=$location->longitude&radius=0");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 1)
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $location->id)
                            ->where('name', $location->name)
                            ->where('latitude', $location->latitude)
                            ->where('longitude', $location->longitude)
                    )
            );
    }

    /**
     * Generates a random coordinate between a given min and max value
     */
    protected function generateRandomCoordinate(float $min, float $max, int $decimals = 17): float
    {
        $divisor = pow(10, $decimals);

        return rand($min, $max * $divisor) / $divisor;
    }
}
