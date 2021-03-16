<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run() {
        $companies = [];
        $companies[] = [
            'external_id' => '',
            'name' => 'DS.Med',
            'director_id' => '1',
            'phone' => '+7 (495) 248-12-21',
            'email' => 'e.semochkin@ds-med.ru'
        ];
        \DB::table('companies')->insert($companies);
    }
}
