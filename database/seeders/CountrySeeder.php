<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
          ['name' => 'Bangladesh', 'code' => 'BD'],
          ['name' => 'United Kingdom', 'code' => 'UK'],
          ['name' => 'Canada', 'code' => 'CA'],
          ['name' => 'United States', 'code' => 'US'],
          ['name' => 'China', 'code' => 'CN'],
          ['name' => 'India', 'code' => 'IN'],
          ['name' => 'Brazil', 'code' => 'BR'],
          ['name' => 'Australia', 'code' => 'AU'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
