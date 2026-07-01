<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $farsState = State::where('name', 'فارس')->first();

        $cities = [
            ['name' => 'لار', 'slug' => 'lar', 'state_id' => $farsState?->id],
            ['name' => 'شیراز', 'slug' => 'shiraz', 'state_id' => $farsState?->id],
        ];

        foreach($cities as $city){
            // فقط اگه استان وجود داشت بساز
            // بررسی اینکه حتما این کلید در هر ردیف وجود داشته باشه
            if(isset($city['state_id']) && $city['state_id'] !== null){
                City::firstOrCreate([
                    'slug' => $city['slug']], $city);
            }
        }
    }
}
