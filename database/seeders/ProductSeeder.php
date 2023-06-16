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
                'name' => '商品名1',
                'price' => 1000,
                'stock' => 10,
                'manufacturer' => 'メーカー名1',
                'details' => '商品説明1',
            ],
            [
                'image' => 'path/to/image2.jpg',
                'name' => '商品名2',
                'price' => 2000,
                'stock' => 5,
                'manufacturer' => 'メーカー名2',
                'details' => '商品説明2',
            ],
            // 他の商品データを追加する場合はここに記述
        ];

        // 商品データをデータベースに保存
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}


