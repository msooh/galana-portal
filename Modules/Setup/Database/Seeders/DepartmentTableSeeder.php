<?php

namespace Modules\Setup\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Retail', 'Finance', 'Lubricants', 'Consumer', 'HR & Admin', 
            'Engineering', 'ICT', 'Hsseq', 'Supply', 'Trading & Exports', 'Operations'
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'name' => $department,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

