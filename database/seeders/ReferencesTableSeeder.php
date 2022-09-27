<?php

namespace Database\Seeders;

use App\Models\References;
use Illuminate\Database\Seeder;

class ReferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'code'       => 'overtime_method',
                'name'       => 'Salary / 173',
                'expression' => '(salary / 173) * overtime_duration_total',
            ],
            [
                'code'       => 'overtime_method',
                'name'       => 'Fixed',
                'expression' => '10000 * overtime_duration_total',
            ],
        ];
        References::insert($data);
    }
}
