<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function search(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'string|nullable',
        'manufacturer' => 'string|nullable',
        'min_price' => 'numeric|nullable',
        'max_price' => 'numeric|nullable',
    ]);

    $products = Product::query()
        ->when($validatedData['name'], function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
        ->when($validatedData['manufacturer'], function ($query, $manufacturer) {
            return $query->where('manufacturer', 'like', '%' . $manufacturer . '%');
        })
        ->when($validatedData['min_price'], function ($query, $minPrice) {
            return $query->where('price', '>=', $minPrice);
        })
        ->when($validatedData['max_price'], function ($query, $maxPrice) {
            return $query->where('price', '<=', $maxPrice);
        })
        ->get();

    return view('products.search', compact('products'));
}

}
