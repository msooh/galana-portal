<?php

namespace Modules\Retail\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Retail\Entities\Category;
use Modules\Retail\Entities\Subcategory;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::where('name', 'Quality Checklist')->first();

        if ($category) {
            $subcategories = [
                [
                    'name' => 'Forecourt & Vicinity',
                    'description' => 'Forecourt & Vicinity subcategory.',
                    'category_id' => $category->id,
                    'created_by' => '1'
                ],
                [
                    'name' => 'Displays & Equipment',
                    'description' => 'Displays & Equipment subcategory.',
                    'category_id' => $category->id,
                    'created_by' => '1'
                ],
                [
                    'name' => 'Services & Hospitality',
                    'description' => 'Services & Hospitality subcategory.',
                    'category_id' => $category->id,
                    'created_by' => '1'
                ],
                [
                    'name' => 'HSE',
                    'description' => 'HSE subcategory.',
                    'category_id' => $category->id,
                    'created_by' => '1'
                ],
                [
                    'name' => 'Office, Shop & Service Bays',
                    'description' => 'Office, Shop & Service Bays category.',
                    'category_id' => $category->id,
                    'created_by' => '1'
                ],
                [
                    'name' => 'Management',
                    'description' => 'Management subcategory.',
                    'category_id' => $category->id,
                    'created_by' => '1'
                ],
                [
                    'name' => 'Stocks',
                    'description' => 'Stocks subcategory.',
                    'category_id' => $category->id,
                    'created_by' => '1'
                ],
            ];
            foreach ($subcategories as $subcategoryData) {
                Subcategory::create($subcategoryData);
            }

        }
    }
}
