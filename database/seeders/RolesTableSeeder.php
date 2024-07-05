<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Define role data
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'Territory Manager (TM)'],
            ['name' => 'Retail Manager'],
            ['name' => 'Hsseq'],
        ];

        // Insert roles into the database
        DB::table('roles')->insert($roles);
    }
}
