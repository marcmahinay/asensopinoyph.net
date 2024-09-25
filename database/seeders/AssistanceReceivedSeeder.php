<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AssistanceReceivedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create a set to store unique combinations
        $usedCombinations = [];

        // Increase the loop count to ensure we can generate 50 unique records
        for ($i = 0; $i < 100; $i++) {
            $assistanceEventId = $faker->numberBetween(1, 5);
            $beneficiaryId = $faker->numberBetween(1, 398);

            // Check if the combination is unique
            if (!in_array("$assistanceEventId-$beneficiaryId", $usedCombinations)) {
                $usedCombinations[] = "$assistanceEventId-$beneficiaryId";

                DB::table('assistance_received')->insert([
                    'assistance_event_id' => $assistanceEventId,
                    'beneficiary_id' => $beneficiaryId,
                    'amount_received' => $faker->optional(0.7)->randomFloat(2, 10, 1000),
                    'items_received' => $faker->optional(0.6)->sentence(),
                    'received_at' => $faker->dateTimeBetween('-1 year', 'now'),
                    'status' => $faker->randomElement(['received', 'pending', 'cancelled']),
                    'notes' => $faker->optional(0.4)->paragraph(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Break the loop if we've inserted 50 unique records
                if (count($usedCombinations) >= 50) {
                    break;
                }
            }
        }
    }
}
