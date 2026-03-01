<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            'فيزا',
            'ماستر كارد',
            'مدى',
            'خليجة',
        ];

        foreach ($methods as $method) {
            PaymentMethod::firstOrCreate([
                'name' => $method
            ]);
        }
    }
}
