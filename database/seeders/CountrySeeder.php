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
          ['name' => 'Germany', 'code' => 'DE'],
          ['name' => 'Baden-Württemberg', 'code' => 'BW'],
          ['name' => 'Bayern', 'code' => 'BY'],
          ['name' => 'Berlin', 'code' => 'BE'],
          ['name' => 'Brandenburg', 'code' => 'BB'],
          ['name' => 'Bremen', 'code' => 'HB'],
          ['name' => 'Hamburg', 'code' => 'HH'],
          ['name' => 'Hessen', 'code' => 'HE'],
          ['name' => 'Mecklenburg-Vorpommern', 'code' => 'MV'],
          ['name' => 'Niedersachsen', 'code' => 'NI'],
          ['name' => 'Nordrhein-Westfalen', 'code' => 'NW'],
          ['name' => 'Rheinland-Pfalz', 'code' => 'RP'],
          ['name' => 'Saarland', 'code' => 'SL'],
          ['name' => 'Sachsen', 'code' => 'SN'],
          ['name' => 'Sachsen-Anhalt', 'code' => 'ST'],
          ['name' => 'Schleswig-Holstein', 'code' => 'SH'],
          ['name' => 'Thüringen', 'code' => 'TH'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
