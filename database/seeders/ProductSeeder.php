<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // 商品情報の初期データを作成
        $products = [
            [
                'image' => 'path/to/image1.jpg',
                'product_name' => '商品名1',
                'price' => 1000,
                'stock' => 10,
                'company_id' => '1',
                'comment' => '商品説明1',
            ],
            [
                'image' => 'path/to/image1.jpg',
                'product_name' => '商品名1',
                'price' => 1000,
                'stock' => 10,
                'company_id' => '2',
                'comment' => '商品説明1',
            ],
            // 他の商品データを追加する場合はここに記述
        ];

        // 商品データをデータベースに保存
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}


