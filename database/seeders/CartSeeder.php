<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define data to be inserted into the cart table
        $cartData = [
            [
                'user_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
            ],
            [
                'user_id' => 2,
                'product_id' => 3,
                'quantity' => 1,
            ],
            // Add more data as needed
        ];

        // Insert data into the cart table
        foreach ($cartData as $data) {
            Cart::create($data);
        }
    }
}
