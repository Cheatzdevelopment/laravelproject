<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ១. បង្កើតគណនីអ្នកប្រើប្រាស់ (Users)
        // ---------------------------------------------------------

        // Owner (ម្ចាស់ហាង)
        User::updateOrCreate(
            ['email' => 'owner@myshop.com'],
            [
                'name' => 'Owner Boss',
                'password' => Hash::make('20262027'), // New Password
                'role' => 'owner',
                'email_verified_at' => now(),
            ]
        );

        // Admin (អ្នកគ្រប់គ្រង)
        User::updateOrCreate(
            ['email' => 'admin@myshop.com'],
            [
                'name' => 'Admin Manager',
                'password' => Hash::make('20262027'), // New Password
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Cashier (អ្នកគិតលុយ)
        User::updateOrCreate(
            ['email' => 'cashier@myshop.com'],
            [
                'name' => 'Cashier Staff',
                'password' => Hash::make('20262027'), // New Password
                'role' => 'cashier',
                'email_verified_at' => now(),
            ]
        );

        // User (អតិថិជន)
        $customer = User::updateOrCreate(
            ['email' => 'user@myshop.com'],
            [
                'name' => 'Customer 001',
                'password' => Hash::make('20262027'), // New Password
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        echo "✅ Users Created/Updated with Password '20262027'.\n";


        // ២. បង្កើតទំនិញគំរូ (Products)
        // ---------------------------------------------------------
        $productsData = [
            [
                'name' => 'កាហ្វេទឹកដោះគោ (Iced Latte)',
                'price' => 2.50,
                'stock' => 100,
                'description' => 'កាហ្វេអារ៉ាប៊ីកា លាយជាមួយទឹកដោះគោស្រស់។',
                'image' => null,
            ],
            [
                'name' => 'បាយឆាសាច់ជ្រូក (Fried Rice)',
                'price' => 3.00,
                'stock' => 50,
                'description' => 'បាយឆាក្តៅៗជាមួយសាច់ជ្រូក និងពងទា។',
                'image' => null,
            ],
            [
                'name' => 'តែបៃតង (Green Tea)',
                'price' => 2.00,
                'stock' => 5,
                'description' => 'តែបៃតងទឹកដោះគោ រសជាតិដើម។',
                'image' => null,
            ],
            [
                'name' => 'ទឹកសុទ្ធ (Water)',
                'price' => 0.50,
                'stock' => 0,
                'description' => 'ទឹកបរិសុទ្ធចំណុះ 500ml។',
                'image' => null,
            ],
        ];

        foreach ($productsData as $data) {
            Product::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        echo "✅ Products Created Successfully.\n";


        // ៣. បង្កើតការលក់គំរូ (Orders & OrderItems)
        // ---------------------------------------------------------
        $latte = Product::where('name', 'like', '%Latte%')->first();
        $rice = Product::where('name', 'like', '%Fried Rice%')->first();

        if ($latte && $rice) {
            // Order ទី ១ (ថ្ងៃនេះ)
            $order1 = Order::firstOrCreate(
                [
                    'user_id' => $customer->id,
                    'created_at' => Carbon::today(),
                ],
                [
                    'total_price' => 5.50,
                    'status' => 'paid',
                    'payment_method' => 'KHQR',
                    'order_type' => 'delivery',
                ]
            );

            if ($order1->wasRecentlyCreated) {
                OrderItem::create([
                    'order_id' => $order1->id,
                    'product_id' => $latte->id,
                    'quantity' => 1,
                    'price' => $latte->price,
                ]);
                OrderItem::create([
                    'order_id' => $order1->id,
                    'product_id' => $rice->id,
                    'quantity' => 1,
                    'price' => $rice->price,
                ]);
            }

            // Order ទី ២ (ម្សិលមិញ)
            $order2 = Order::firstOrCreate(
                [
                    'user_id' => $customer->id,
                    'created_at' => Carbon::yesterday(),
                ],
                [
                    'total_price' => 6.00,
                    'status' => 'paid',
                    'payment_method' => 'cash',
                    'order_type' => 'pickup',
                ]
            );

            if ($order2->wasRecentlyCreated) {
                OrderItem::create([
                    'order_id' => $order2->id,
                    'product_id' => $rice->id,
                    'quantity' => 2,
                    'price' => $rice->price,
                ]);
            }

            echo "✅ Fake Orders Created Successfully.\n";
        }
    }
}
