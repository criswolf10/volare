<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        Flight::factory(10)->create();


    }
}
