<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(ProvinceSeeder::class);
        $this->call(MisoccMunicipalityCitySeeder::class);
        $this->call(MisoccBarangaySeeder::class);
        $this->call(CivilStatusSeeder::class);
        $this->call(AssistanceTypeSeeder::class);
        $this->call(AssistanceEventSeeder::class);
        $this->call(BeneficiaryTudelaSeeder::class);
        //$this->call(AssistanceReceivedSeeder::class);
        //$this->call(VoucherSeeder::class);
        //$this->call(VoucherCodeSeeder::class);


        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@asensopinoyph.net',
            'password' => Hash::make('asensoP1n0Y'),
        ]);
    }
}
