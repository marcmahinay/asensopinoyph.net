<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VoucherCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voucherCodes = [];
        $redeemedCount = 0;
        $existingCombinations = DB::table('voucher_codes')
            ->select('voucher_id', 'beneficiary_id')
            ->get()
            ->map(function ($item) {
                return $item->voucher_id . '-' . $item->beneficiary_id;
            })
            ->flip()
            ->toArray();

        while (count($voucherCodes) < 50) {
            $voucherId = rand(1, 2);
            $beneficiaryId = rand(1, 398);
            $combinationKey = $voucherId . '-' . $beneficiaryId;

            if (isset($existingCombinations[$combinationKey])) {
                continue;
            }

            $isRedeemed = $redeemedCount < 40 ? (rand(0, 1) == 1) : false;
            if ($isRedeemed) {
                $redeemedCount++;
            }

            $voucherCodes[] = [
                'voucher_id' => $voucherId,
                'code' => strtoupper(Str::random(8)),
                'beneficiary_id' => $beneficiaryId,
                'is_redeemed' => $isRedeemed,
                'redeemed_at' => $isRedeemed ? Carbon::now()->subDays(rand(1, 30)) : null,
                'redemption_location' => $isRedeemed ? 'Location ' . rand(1, 10) : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $existingCombinations[$combinationKey] = true;
        }

        DB::table('voucher_codes')->insert($voucherCodes);
    }
}
