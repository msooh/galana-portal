<?php

namespace Modules\Retail\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Retail\Entities\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Quality Checklist',
                'description' => 'Quality Checklist category.'
            ],            
          
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description']
            ]);
        }
    }
}
