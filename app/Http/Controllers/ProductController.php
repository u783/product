<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\Models\Company;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();

    if ($request->has('search')) {
        $search = '%' . $request->input('search') . '%';
        $query->where('name', 'like', $search)
            ->orWhere('manufacturer', 'like', $search);
    }

    $products = $query->paginate(10);

    // 追加の処理
    $allProducts = Product::all();

    return view('products.index', compact('products', 'allProducts'));
}


public function create()
{
    $companies = Company::all();
    return view('products.create', compact('companies'));
}


public function store(Request $request)
{
    DB::beginTransaction(); // トランザクション開始

    try {
        // 商品の作成と保存
        $product = new Product();
        $product->name = $request->input('name');
        $product->manufacturer = $request->input('manufacturer');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->details = $request->input('details');
        $product->save();

        // 画像の保存
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/storage');
            $imagePath = str_replace('public/storage/', '', $imagePath);
            $product->image = $imagePath;
        }

        $product->save();

        DB::commit(); // トランザクションのコミット

        return redirect()->route('products.index')->with('success', config('messages.store_success'));
    } catch (\Exception $e) {
        DB::rollBack(); // トランザクションのロールバック

        return redirect()->route('products.index')->with('error', config('messages.store_error'));
    }
}


public function show(Product $product)
{
    $product->load('company'); // 'company' リレーションをロード

    return view('products.show', compact('product'));
}

public function edit(Product $product)
{
    $companies = Company::all();
    return view('products.edit', compact('product', 'companies'));
}


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', config('messages.delete_success'));
    }

    public function update(Request $request, Product $product)
{
    try {
        $product->name = $request->input('name');
        $product->manufacturer = $request->input('manufacturer');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->details = $request->input('details');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public');
            $product->image = Storage::url($imagePath);
        }

        $product->save();

        $successMessage = config('messages.update_success');
        return redirect()->route('products.index')->with('success', $successMessage);
    } catch (\Exception $e) {
        $errorMessage = config('messages.update_error');
        return redirect()->route('products.index')->with('error', $errorMessage);
    }
}
}