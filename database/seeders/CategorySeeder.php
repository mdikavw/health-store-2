<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Health Supplements',
                'description' => 'Various supplements to support health and wellness.',
                'icon' => 'fa-solid fa-pills',
            ],
            [
                'name' => 'Medical Devices',
                'description' => 'Devices for medical diagnostics and treatment.',
                'icon' => 'fa-solid fa-stethoscope',
            ],
            [
                'name' => 'Personal Care',
                'description' => 'Products for personal hygiene and care.',
                'icon' => 'fa-solid fa-soap',
            ],
            [
                'name' => 'Fitness Equipment',
                'description' => 'Equipment to enhance physical fitness and exercise routines.',
                'icon' => 'fa-solid fa-dumbbell',
            ],
            [
                'name' => 'Vitamins',
                'description' => 'A variety of vitamins to support overall health and vitality.',
                'icon' => 'fa-solid fa-vitamin',
            ],
            [
                'name' => 'Essential Oils',
                'description' => 'Therapeutic essential oils for wellness and relaxation.',
                'icon' => 'fa-solid fa-oil-can',
            ],
            [
                'name' => 'First Aid',
                'description' => 'First aid supplies for immediate medical assistance.',
                'icon' => 'fa-solid fa-kit-medical',
            ],
            [
                'name' => 'Nutritional Snacks',
                'description' => 'Healthy snacks to complement a balanced diet.',
                'icon' => 'fa-solid fa-cookie-bite',
            ],
            [
                'name' => 'Home Testing Kits',
                'description' => 'Testing kits for health and wellness monitoring at home.',
                'icon' => 'fa-solid fa-flask',
            ],
            [
                'name' => 'Herbal Remedies',
                'description' => 'Natural remedies and herbs for various health conditions.',
                'icon' => 'fa-solid fa-leaf',
            ]
        ]);
    }
}
