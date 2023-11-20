<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;

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

        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');

        if($column === 'company_name') {
            $query->leftJoin('companies', 'product.company_id', '=', 'companies.id')
                  ->orderBy('companies.name', $order)
                  ->select('products.*');
        }


        if ($request->has('min_price')) {
            $query->where('price', '>=', (float)$request->input('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', (float)$request->input('max_price'));
        }
        if ($request->has('min_stock')) {
            $query->where('stock', '>=', (float)$request->input('min_stock'));
        }
        if ($request->has('max_stock')) {
            $query->where('stock', '<=', (float)$request->input('max_stock'));
        }
        
        $products = $query->paginate(10);

        $productsWithCompanies = Product::with('company')->paginate(10);

        return view('products.index', compact('products', 'productsWithCompanies'));
    }

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

            $product = new Product();
            $product->name = $validateData['name'];
            $product->manufacturer = $validateData['manufacturer'];
            $product->price = $validateData['price'];
            $product->stock = $validateData['stock'];
            $product->details = $validateData['details'];

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
        $product->load('company');

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
            DB::beginTransaction();

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

            DB::commit();

            $successMessage = config('messages.update_success');
            return redirect()->route('products.index')->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollBack();

            $errorMessage = config('messages.update_error');
            return redirect()->route('products.index')->with('error', $errorMessage);
        }
    }

    public function search(Request $request)
    {
        $query = Product::query();

        // バリデーション（必要に応じて）
        $request->validate([
            'search' => 'string|nullable',
            'min_price' => 'numeric|nullable',
            'max_price' => 'numeric|nullable',
            'min_stock' => 'numeric|nullable',
            'max_stock' => 'numeric|nullable',
        ]);

        // クエリビルダーを使用して動的に検索条件を組み立てる
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where('name', 'like', $searchTerm)
                ->orWhere('manufacturer', 'like', $searchTerm);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float)$request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float)$request->input('max_price'));
        }

        if ($request->filled('min_stock')) {
            $query->where('stock', '>=', (float)$request->input('min_stock'));
        }

        if ($request->filled('max_stock')) {
            $query->where('stock', '<=', (float)$request->input('max_stock'));
        }

        // 他の条件に基づく検索条件も追加可能

        // 検索実行
        $results = $query->paginate(10);

        // 検索結果をビューに渡す
        return view('products.index', compact('results'));
    }
}
