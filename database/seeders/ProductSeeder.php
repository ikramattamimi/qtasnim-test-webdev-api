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
        DB::table('products')->insert([
            [
                'name' => 'Kopi',
                'stock' => '75',
                'product_type_id' => 1,
            ],
            [
                'name' => 'Teh',
                'stock' => '76',
                'product_type_id' => 1,
            ],
            [
                'name' => 'Pasta Gigi',
                'stock' => '80',
                'product_type_id' => 2,
            ],
            [
                'name' => 'Sabun Mandi',
                'stock' => '70',
                'product_type_id' => 2,
            ],
            [
                'name' => 'Sampo',
                'stock' => '75',
                'product_type_id' => 2,
            ],
        ]);
    }
}
