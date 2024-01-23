<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Http\Livewire\ProductList;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $order = $request->session()->get('order', 'asc');
    $column = $request->input('column', 'id');

    // Call the search method to get the data
    $data = $this->search($request, $column, $order);

    // Convert the view data to an array
    $dataArray = $data->getData();

    // Render the Livewire component's view
    return view('products.index', $dataArray);
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
    $companyName = $request->input('company_name');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $minStock = $request->input('min_stock');
    $maxStock = $request->input('max_stock');

    // リクエストからソート条件を取得
    $order = $request->session()->get('order', 'asc');
    $column = $request->input('column', 'id');

    // 商品データを検索
    $query = Product::query();

    // Apply search conditions
    if ($search) {
        $query->where(function ($query) use ($search) {
            $query->where('product_name', 'like', '%' . $search . '%')
                  ->orWhere('comment', 'like', '%' . $search . '%');
        });
    }

    if ($companyName) {
        $query->whereHas('company', function ($q) use ($companyName) {
            $q->where('company_name', 'like', '%' . $companyName . '%');
        });
    }

    if ($minPrice && $maxPrice) {
        $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    if ($minStock && $maxStock) {
        $query->whereBetween('stock', [$minStock, $maxStock]);
    }

    $query->orderBy($column, $order);

    $productsWithCompanies = $query->with('company')->paginate(10);

    $products = Product::with('company')->get();
    
    // 商品データをビューに返す
    return view('livewire.product-list', compact('productsWithCompanies', 'order', 'column'));
}
}