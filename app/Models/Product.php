<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;


class Product extends Model
{
    // データの取得
    public static function getAllProducts()
    {
        return self::all();
    }

    // データの登録
    public static function createProduct($data)
    {
        return self::create($data);
    }

    // データの更新
    public function updateProduct($data)
    {
        return $this->update($data);
    }

    
}
