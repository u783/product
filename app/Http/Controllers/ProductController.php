<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;


class YourController extends Controller
{
    public function yourMethod(Request $request)
    {
        // 以下の行を追加してブラウザキャッシュを無効にします。
        $response = response()->view('your.view.name');
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        return $response;
    }
}

class ProductController extends Controller
{
    // ...

public function index(Request $request)
{
    $query = Product::query();

    if ($request->has('search')) {
        $search = '%' . $request->input('search') . '%';
        $query->where('name', 'like', $search)
            ->orWhere('manufacturer', 'like', $search);
    }

    $column = $request->input('column', 'id');
    $order = $request->input('order', 'asc');

    $query->orderBy($column, $order);

    if ($request->has('min_price')) {
        $query->where('price', '>=', $request->input('min_price'));
    }
    if ($request->has('max_price')) {
        $query->where('price', '<=', $request->input('max_price'));
    }
    if ($request->has('min_stock')) {
        $query->where('stock', '>=', $request->input('min_stock'));
    }
    if ($request->has('max_stock')) {
        $query->where('stock', '<=', $request->input('max_stock'));
    }

    $products = $query->paginate(10);

    $productsWithCompanies = Product::with('company')->paginate(10);

    return view('products.index', compact('products', 'productsWithCompanies'));
}

// ...




public function create()
{
    $companies = Company::all();
    return view('products.create', compact('companies'));
}


public function store(ProductRequest $request)
{
    DB::beginTransaction(); // トランザクション開始

    try {
        $validateData = $request->validated();

        // 商品の作成と保存
        $product = new Product();
        $product->name = $validateData['name'];
        $product->manufacturer = $validateData['manufacturer'];
        $product->price = $validateData['price'];
        $product->stock = $validateData['stock'];
        $product->details = $validateData['details'];

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
        try {
            DB::beginTransaction();//トランザクション開始

            $product->delete();//商品の削除

            DB::commit();//トランザクションのコミット

            return redirect()->route('products.index')->with('success', config('messages.delete_success'));
        } catch (\Exception $e) {
            DB::rollBack(); // トランザクションのロールバック

            return redirect()->route('products.index')->with('error', config('messages.delete_error'));
        }
    }

public function update(Request $request, Product $product)
{
    try {
        DB::beginTransaction(); // トランザクション開始

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

        $product->save(); // 商品の更新

        DB::commit(); // トランザクションのコミット

        $successMessage = config('messages.update_success');
        return redirect()->route('products.index')->with('success', $successMessage);
    } catch (\Exception $e) {
        DB::rollBack(); // トランザクションのロールバック

        $errorMessage = config('messages.update_error');
        return redirect()->route('products.index')->with('error', $errorMessage);
    }
}
}
