<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::create([
            "key"=> "DelayAtAnyPoint",
            "value"=> "5",
        ]);
        Config::create([
            "key"=> "CarBaseAmount",
            "value"=> "25",
        ]);
        Config::create([
            "key"=> "BikeBaseAmount",
            "value"=> "30",
        ]);
        Config::create([
            "key"=> "TotalDelayTime",
            "value"=> "15",
        ]);
        Config::create([
            "key"=> "EveryAdditionalKMOfTheCar",
            "value"=> "5",
        ]);
        Config::create([
            "key"=> "EveryAdditionalKMOfTheBike",
            "value"=> "6",
        ]);
    }
}
