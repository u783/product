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
    $order = $request->session()->get('order', 'asc');

    $query = Product::query();

    if ($request->has('search')) {
        $search = '%' . $request->input('search') . '%';
        $query->where('product_name', 'like', $search)
            ->orWhereHas('company', function ($q) use ($search) {
                $q->where('company_name', 'like', $search);
            });
        }

    $column = $request->input('column', 'id');
    $order = $request->input('order', 'asc');

    if ($column === 'company_name') {
        $query->join('companies', 'products.company_id', '=', 'companies.id')
              ->orderBy('companies.company_name', $order)
              ->select('products.*');
    } else {
        $query->orderBy($column, $order);
    }

    $request->session()->put('order', $order === 'asc' ? 'desc' : 'asc');

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

    $productsWithCompanies = $query->with('company')->paginate(10);

    $products = Product::with('company')->get();

    $companies = Company::all();

    return view('products.index', compact('productsWithCompanies', 'order', 'column'));
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
            $validateData = $request->validated();;

            $product = new Product();
            $product->product_name = $validateData['product_name'];
            $product->company_id = $validateData['company_id'];
            $product->price = $validateData['price'];
            $product->stock = $validateData['stock'];
            $product->comment = $validateData['comment'];

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

        if ($product->company) {
            // Company found, display the view with the company data
            return view('products.show', compact('product'));
        } else {
            // Company not found, handle this case (you can customize this part)
            
            return view('products.show', compact('product'))->with('error', 'No associated company found.');
        }
        }


    public function edit(Product $product)
    {
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    public function destroy(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();

            // Delete related sales records
            $product->sales()->delete();

            // Now, delete the product
            $product->delete();

            DB::commit();

            // リクエストが Ajax かどうかを判定し、結果を JSON で返す
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->route('products.index')->with('success', config('messages.delete_success'));
        } catch (\Exception $e) {
            DB::rollBack();

            // エラー時も同様に JSON レスポンスを返す
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => config('messages.delete_error')]);
            }

            return redirect()->route('products.index')->with('error', config('messages.delete_error'));
        }
    }



    public function update(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();

            $product->product_name = $request->input('product_name');
            $product->company_id = $request->input('company_id');
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');
            $product->comment = $request->input('comment');

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
        // リクエストから検索条件を取得
        $search = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $minStock = $request->input('min_stock');
        $maxStock = $request->input('max_stock');

        // 商品データを検索
        $query = Product::query()
           ->when($searchInput, function ($query) use ($searchInput) {
            $query->where('name', 'like', '%', $searchInput . '%');
           })
           ->when($compayId, function ($query) use ($compayId) {
            $query->where('company_id', $comanyId);
           })
           ->get();

           $companies = Company::all();

        if ($search) {
            $query->where('product_name', 'like', '%' . $search . '%')
                  ->orWhere('comment', 'like', '%' . $search . '%');
        }

        if ($minPrice && $maxPrice) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }

        if ($minStock && $maxStock) {
            $query->whereBetween('stock', [$minStock, $maxStock]);
        }

        $products = $query->get();

        // 商品データをビューに返す
        return view('products.search', compact('products'));
    }
}
