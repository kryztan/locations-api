<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the location table seeds.
     */
    public function run(): void
    {
        Location::truncate();

        $csvData = fopen(database_path('csv/data.csv'), 'r');

        while (($data = fgetcsv($csvData, 500, ',')) !== false) {
            Location::create([
                'name' => $data['0'],
                'latitude' => $data['1'],
                'longitude' => $data['2']
            ]);
        }

        fclose($csvData);
    }
}
