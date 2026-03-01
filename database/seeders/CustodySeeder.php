<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Custody;

class CustodySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'ابو انور',
            'وجبة عمال',
            'مصروفات مخبز',
            'مصروفات اجبان',
            'مصروفات خضار',
            'مصروفات محل',
            'عبد الله المطوع',
            'سفيان الشعيبي',
            'يحيى عبد الله',
            'أيمن معكفي',
            'مصطفى علي احمد',
            'ابو احمد',
        ];

        foreach ($items as $item) {
            Custody::firstOrCreate([
                'name' => $item
            ]);
        }
    }
}
