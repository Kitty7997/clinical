<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        DB::table('coupon')->insert([
            [
            'code' => 'HERTILITYHEALTH',
            'discount' => 35,
            'type' => 'amount',
            ],
            [
            'code' => 'TEJENDER',
            'discount' => 10,
            'type' => 'percentage',
            ]

        ]);
    }
}
