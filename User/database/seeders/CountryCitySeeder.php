<?php

namespace User\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PragmaRX\Countries\Package\Countries;
use User\Models\City;
use User\Models\Country;

/**
 * Class AuthTableSeeder.
 */
class CountryCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            set_time_limit(999999999999);
            ini_set('max_execution_time',999999999999);
            $ll = new Countries();
            $cities = [];
            foreach($ll->all()->hydrate('cities')->toArray() AS $country_key => $country){
                foreach($country['cities'] AS $key => $city) {
                    if(is_array($city))
                        if(array_key_exists('adm0name',$city) AND !empty($city['adm1name']) AND !empty($city['name_en']) AND !empty($city['cca2'])) {
                            Country::query()->firstOrCreate([
                                'name' => $city['adm0name'],
                                'iso2' => $city['cca2']
                            ]);
                            $cities[$city['sov0name']][$city['adm1name']][] = $city['name_en'];
                        }
                }
            }
            $now = now()->toDateTimeString();
            $cities_to_db = [];
            foreach($cities AS $country => $states) {
                $country = Country::query()->firstOrCreate([
                    'name' => $country
                ]);
                foreach($states AS $state => $cities) {
                    $state = City::query()->firstOrCreate([
                        'name' => $state,
                        'country_id' => $country->id
                    ]);
                    foreach($cities AS $city) {
                        $cities_to_db[] = [
                            'country_id' => $country->id,
                            'parent_id' => $state->id,
                            'name' => $city,
                            'created_at' => $now,
                            'updated_at' => $now
                        ];
                    }
                    $cities_to_db[] = [
                        'country_id' => $country->id,
                        'parent_id' => $state->id,
                        'name' => 'Others',
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }
                $state = $country->states()->firstOrCreate([
                    'name' => 'Others'
                ]);
                $state->cities()->firstOrCreate([
                    'name' => 'Others',
                    'country_id' => $country->id
                ]);
            }
            foreach(collect($cities_to_db)->chunk(150) AS $chunked_cities)
                City::query()->insert($chunked_cities->toArray());
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;

        }
    }
}
