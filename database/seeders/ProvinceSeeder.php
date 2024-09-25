<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $sql = file_get_contents(database_path('seeders/provinces.sql'));
        DB::unprepared($sql);
    }
}
