<?php

namespace Modules\Retail\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Retail\Entities\Checklist;
use Modules\Retail\Entities\Subcategory;


class ForecourtChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forecourtCategory = Subcategory::where('name', 'Forecourt & Vicinity')->first();

        if ($forecourtCategory) {
            $checklists = [
                [
                    'name' => 'Forecourt entrance/exit (clean & clear) no broken down vehicles',
                    'sub_category_id' => $forecourtCategory->id,
                ],                
                [
                    'name' => 'Signs visible & clean',
                    'sub_category_id' => $forecourtCategory->id,
                ],
                [
                    'name' => 'Signs free from damage',
                    'sub_category_id' => $forecourtCategory->id,
                ],
                [
                    'name' => 'Entire Forecourt clean and drainage are clean',
                    'sub_category_id' => $forecourtCategory->id,
                ],
                [
                    'name' => 'Green areas clean & well-kept, no litter',
                    'sub_category_id' => $forecourtCategory->id,
                ],
                [
                    'name' => 'Kerbs are clean',
                    'sub_category_id' => $forecourtCategory->id,
                ],
                [
                    'name' => 'Canopy clean & not damaged, No Cobwebs',
                    'sub_category_id' => $forecourtCategory->id,
                ],
                [
                    'name' => 'No external car parked on the station. No old or broken down vehicles left in the station',
                    'sub_category_id' => $forecourtCategory->id,
                ],
                [
                    'name' => 'No Unnecessary poster. No posters pasted on walls and windows',
                    'sub_category_id' => $forecourtCategory->id,
                ],
            ];

            foreach ($checklists as $checklist) {
                Checklist::create($checklist);
            }
        }
    }
}
