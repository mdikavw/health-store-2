<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            1 => [ // Health Supplements
                ['name' => 'Vitamin C Tablets', 'description' => 'Boost your immune system with Vitamin C.', 'price' => 50000, 'stock' => 100, 'image_url' => 'images/products/vitamin_c_tablets.jpg'],
                ['name' => 'Multivitamin Gummies', 'description' => 'Delicious gummies packed with essential vitamins.', 'price' => 75000, 'stock' => 150, 'image_url' => 'images/products/multivitamin_gummies.jpg'],
            ],
            2 => [ // Medical Devices
                ['name' => 'Digital Blood Pressure Monitor', 'description' => 'Accurate and easy-to-use blood pressure monitor.', 'price' => 150000, 'stock' => 50, 'image_url' => 'images/products/blood_pressure_monitor.jpg'],
                ['name' => 'Pulse Oximeter', 'description' => 'Portable pulse oximeter for measuring oxygen levels.', 'price' => 90000, 'stock' => 80, 'image_url' => 'images/products/pulse_oximeter.jpg'],
            ],
            3 => [ // Personal Care
                ['name' => 'Organic Hand Cream', 'description' => 'Moisturizing hand cream with natural ingredients.', 'price' => 30000, 'stock' => 200, 'image_url' => 'images/products/organic_hand_cream.jpg'],
                ['name' => 'Gentle Facial Cleanser', 'description' => 'Mild cleanser for a fresh and clean face.', 'price' => 40000, 'stock' => 150, 'image_url' => 'images/products/facial_cleanser.jpg'],
            ],
            4 => [ // Fitness Equipment
                ['name' => 'Adjustable Dumbbells', 'description' => 'Space-saving adjustable dumbbells for your home gym.', 'price' => 120000, 'stock' => 40, 'image_url' => 'images/products/adjustable_dumbbells.jpg'],
                ['name' => 'Yoga Mat', 'description' => 'High-quality yoga mat for comfortable workouts.', 'price' => 35000, 'stock' => 100, 'image_url' => 'images/products/yoga_mat.jpg'],
            ],
            5 => [ // Vitamins
                ['name' => 'Vitamin D Supplements', 'description' => 'Supports bone health and immune function.', 'price' => 40000, 'stock' => 100, 'image_url' => 'images/products/vitamin_d_supplements.jpg'],
                ['name' => 'Omega-3 Fish Oil', 'description' => 'Supports heart health and reduces inflammation.', 'price' => 60000, 'stock' => 120, 'image_url' => 'images/products/omega_3_fish_oil.jpg'],
            ],
            6 => [ // Essential Oils
                ['name' => 'Lavender Essential Oil', 'description' => 'Calming lavender essential oil for relaxation.', 'price' => 25000, 'stock' => 80, 'image_url' => 'images/products/lavender_essential_oil.jpg'],
                ['name' => 'Peppermint Essential Oil', 'description' => 'Refreshing peppermint oil for energy and focus.', 'price' => 28000, 'stock' => 90, 'image_url' => 'images/products/peppermint_essential_oil.jpg'],
            ],
            7 => [ // First Aid
                ['name' => 'First Aid Kit', 'description' => 'Comprehensive first aid kit for home and travel.', 'price' => 75000, 'stock' => 50, 'image_url' => 'images/products/first_aid_kit.jpg'],
                ['name' => 'Antiseptic Ointment', 'description' => 'Essential antiseptic ointment for minor cuts and scrapes.', 'price' => 15000, 'stock' => 300, 'image_url' => 'images/products/antiseptic_ointment.jpg'],
            ],
            8 => [ // Nutritional Snacks
                ['name' => 'Protein Bars', 'description' => 'High-protein bars for a quick energy boost.', 'price' => 20000, 'stock' => 250, 'image_url' => 'images/products/protein_bars.jpg'],
                ['name' => 'Trail Mix', 'description' => 'Nutritious trail mix with nuts and dried fruit.', 'price' => 18000, 'stock' => 200, 'image_url' => 'images/products/trail_mix.jpg'],
            ],
            9 => [ // Home Testing Kits
                ['name' => 'Blood Glucose Test Kit', 'description' => 'Monitor blood glucose levels at home.', 'price' => 70000, 'stock' => 60, 'image_url' => 'images/products/blood_glucose_test_kit.jpg'],
                ['name' => 'Pregnancy Test Kit', 'description' => 'Reliable home pregnancy test for early detection.', 'price' => 25000, 'stock' => 100, 'image_url' => 'images/products/pregnancy_test_kit.jpg'],
            ],
            10 => [ // Herbal Remedies
                ['name' => 'Echinacea Capsules', 'description' => 'Supports immune system health with Echinacea.', 'price' => 30000, 'stock' => 120, 'image_url' => 'images/products/echinacea_capsules.jpg'],
                ['name' => 'Ginger Tea', 'description' => 'Soothing ginger tea for digestion and comfort.', 'price' => 22000, 'stock' => 180, 'image_url' => 'images/products/ginger_tea.jpg'],
            ],
        ];

        foreach ($products as $categoryId => $items)
        {
            foreach ($items as $product)
            {
                DB::table('products')->insert([
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'], // Price in IDR
                    'stock' => $product['stock'],
                    'image_url' => $product['image_url'],
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
