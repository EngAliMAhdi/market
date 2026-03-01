<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [

            ['name' => 'فرع لبن', 'location' => 'شارع عسير - بظهرة لبن'],
            ['name' => 'فرع المهدية', 'location' => 'شارع السيل الكبير - المهدية'],
            ['name' => 'فرع الدرعية', 'location' => 'حي الخالدية - الدرعية'],
            ['name' => 'فرع المونسية', 'location' => 'حي المونسية'],
            ['name' => 'فرع اشبيلية', 'location' => 'طريق الصحابة - اشبيلية'],
            ['name' => 'أسواق السلطان المجمعة', 'location' => 'المجمعة - أحدث وأكبر هايبر ماركت في المنطقة'],
            ['name' => 'فرع حي القدس', 'location' => 'شارع Prince Saud Ibn Abdul Aziz Al Saud Al Kabir Rd, Al Quds, Riyadh 13214'],

        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['name' => $branch['name']], // شرط منع التكرار
                [
                    'location' => $branch['location'],
                    'manager' => null,
                    'phone' => null,
                ]
            );
        }
    }
}
