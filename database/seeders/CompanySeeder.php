<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;


class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'company_name' => 'コカコーラ',
                'street_address' => '東京都',
                'representative_name' => '代表A',
            ],
            [
                'company_name' => 'サントリー',
                'street_address' => '大阪府',
                'representative_name' => '代表B',
            ],
            [
                'company_name' => 'アサヒ',
                'street_address' => '宮城県',
                'representative_name' => '代表C',
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
