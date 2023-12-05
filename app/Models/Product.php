<?php

namespace App\Models;
use App\Models\Company;

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

    public function company()
{
    return $this->belongsTo(Company::class, 'company_id');
}

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    
}
