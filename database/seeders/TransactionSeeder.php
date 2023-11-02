<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transactions')->insert([
            [
                'product_id' => 1,
                'qty' => 10,
                'transaction_date' => '2021-05-01',
            ],
            [
                'product_id' => 2,
                'qty' => 19,
                'transaction_date' => '2021-05-05',
            ],
            [
                'product_id' => 1,
                'qty' => 15,
                'transaction_date' => '2021-05-11',
            ],
            [
                'product_id' => 3,
                'qty' => 20,
                'transaction_date' => '2021-05-11',
            ],
            [
                'product_id' => 4,
                'qty' => 30,
                'transaction_date' => '2021-05-11',
            ],
            [
                'product_id' => 5,
                'qty' => 25,
                'transaction_date' => '2021-05-12',
            ],
            [
                'product_id' => 2,
                'qty' => 5,
                'transaction_date' => '2021-05-12',
            ],
        ]);
    }
}
