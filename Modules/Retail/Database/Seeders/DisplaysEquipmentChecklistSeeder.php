<?php

namespace Modules\Retail\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Retail\Entities\Checklist;
use Modules\Retail\Entities\Subcategory;

class DisplaysEquipmentChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $displaysEquipmentCategory = Subcategory::where('name', 'Displays & Equipment')->first();

        if ($displaysEquipmentCategory) {
            $checklists = [
                [
                    'name' => 'Lube display clean & not damaged',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'Lube display full & well merchandised',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'LPG display full clean & well merchandised price are visibly posted',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'LPG weighing scale in good working condition',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'Islands & pumps clean / no leakage / spills',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'Litter bin available clean & not overflowing',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'Water buckets available clean water',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'Squeegee available and in good condition',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'Compressor room clean / Generator room clean',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'Compressor/ Generator have been serviced and in working condition',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'Tyre pressure Gauge in working condition',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
                [
                    'name' => 'Observe whether station staff check Tyre pressure and not customers',
                    'sub_category_id' => $displaysEquipmentCategory->id,
                ],
            ];

            foreach ($checklists as $checklist) {
                Checklist::create($checklist);
            }
        }
    }
}
