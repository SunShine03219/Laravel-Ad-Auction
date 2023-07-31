<?php

use Illuminate\Database\Seeder;
namespace Database\Seeders;
class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert country first
        $country_sql = file_get_contents(__DIR__.'seeders/dumps/countries.sql');
        // split the statements, so DB::statement can execute them.
        $country_statements = array_filter(array_map('trim', explode(';', $country_sql)));
        foreach ($country_statements as $stmt) {
            \Illuminate\Support\Facades\DB::statement($stmt);
        }

        //Insert State
        $states_sql = file_get_contents(__DIR__.'seeders/dumps/states.sql');
        // split the statements, so DB::statement can execute them.
        $states_statements = array_filter(array_map('trim', explode(';', $states_sql)));
        foreach ($states_statements as $stmt) {
            \Illuminate\Support\Facades\DB::statement($stmt);
        }

        //Insert City
        $cities_sql = file_get_contents(__DIR__.'seeders/dumps/cities.sql');
        // split the statements, so DB::statement can execute them.
        $cities_statements = array_filter(array_map('trim', explode(';', $cities_sql)));
        foreach ($cities_statements as $stmt) {
            \Illuminate\Support\Facades\DB::statement($stmt);
        }
    }
}
