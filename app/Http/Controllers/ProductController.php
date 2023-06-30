<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

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
        return view('products.create');
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->manufacturer = $request->input('manufacturer');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        // 画像のアップロード処理などを追加する場合は適宜実装してください
        $product->details = $request->input('details');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/storage'); // 画像を指定のディレクトリに保存
            $imagePath = str_replace('public/storage/', '', $imagePath); // 保存したパスから"public/"を除去
            $product->image = $imagePath;
            $product->save();
        }        

        return redirect()->route('products.index')->with('success', config('messages.store_success'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
    public function edit(Product $product)
{
    return view('products.edit', compact('product'));
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
