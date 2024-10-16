<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{

    public function run()
    {
        $statuses = [
            ['name' => 'Pending'],
            ['name' => 'Diproses'],
            ['name' => 'Dikirim'],
            ['name' => 'Selesai'],
            ['name' => 'Dibatalkan'],
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
}

