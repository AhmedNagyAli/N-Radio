<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;

class EgyptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the country already exists
        $egypt = Country::firstOrCreate(
            ['country' => 'Egypt'],
            ['id' => 1] // Optional: set a specific ID, remove if auto-incremented
        );

        // List of cities in Egypt
        $cities = [
            'Cairo',
            'Alexandria',
            'Giza',
            'Shubra El Kheima',
            'Port Said',
            'Suez',
            'Luxor',
            'Mansoura',
            'Tanta',
            'Asyut',
            'Ismailia',
            'Faiyum',
            'Zagazig',
            'Damietta',
            'Qena',
            'Sohag',
            'Hurghada',
            'Minya',
            'Beni Suef',
        ];

        // Insert cities for Egypt
        foreach ($cities as $cityName) {
            City::firstOrCreate(
                ['city' => $cityName, 'country_id' => $egypt->id]
            );
        }
    }
}
