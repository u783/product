<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function search(Request $request)
    {
        // リクエストから必要な検索条件を取得
        $name = $request->input('name');
        $manufacturer = $request->input('manufacturer');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Eloquentクエリビルダを使用して検索条件に基づくデータを取得
        $products = Product::query()
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($manufacturer, function ($query) use ($manufacturer) {
                return $query->where('manufacturer', 'like', '%' . $manufacturer . '%');
            })
            ->when($minPrice, function ($query) use ($minPrice) {
                return $query->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query) use ($maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            })
            ->get();

        return view('products.search', compact('products'));
    }
}
