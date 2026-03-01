<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'ملحمة', 'type' => 'rented'],
            ['name' => 'خضار', 'type' => 'owned'],
            ['name' => 'مخبز', 'type' => 'rented'],
            ['name' => 'المحمصة', 'type' => 'rented'],
            ['name' => 'اجبان', 'type' => 'owned'],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate($department);
        }
    }
}
