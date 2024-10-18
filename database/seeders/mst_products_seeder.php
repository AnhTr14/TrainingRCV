<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class mst_products_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cnt = 10;
        for ($i = "J"; $i <= "X"; ++$i) {
            DB::table('mst_products')->insert([
                'product_id' => "S0000000".($cnt++),
                'product_name' => "Sản phẩm ". $i,
                'description' => "Mô tả sản phẩm ". $i,
                'product_price' => rand(10, 200),
                'product_image' => "URL",
                'is_sales' => rand(0, 2),
            ]);
        }
    }
}
