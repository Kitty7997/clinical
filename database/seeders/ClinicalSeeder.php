<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clinical;
use Illuminate\Support\Facades\DB;

class ClinicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clinical')->insert([
            [
                'image' => '../images/health-care-station.jpg',
                'head' => 'Nurse home visit',
                'price' => '79.00',
                'para' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s',
            ],
            [
                'image' => '../images/health-care-station.jpg',
                'head' => 'Fertility Counselling',
                'price' => '85.00',
                'para' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s',
            ],
            [
                'image' => '../images/health-care-station.jpg',
                'head' => 'Nutritional Support',
                'price' => '99.00',
                'para' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s',
            ]
        ]);
    }
}
