<?php

namespace Modules\Retail\Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Retail\Database\Seeders\CategorySeeder;
use Modules\Retail\Database\Seeders\SubcategorySeeder;
use Modules\Retail\Database\Seeders\DisplaysEquipmentChecklistSeeder;
use Modules\Retail\Database\Seeders\ForecourtChecklistSeeder;

class RetailDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(SubcategorySeeder::class);
        $this->call(DisplaysEquipmentChecklistSeeder::class);
        $this->call(ForecourtChecklistSeeder::class);
    }
}
