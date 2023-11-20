<?php
// app/Http/Controllers/PurchaseController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    public function purchase(Request $request)
    {
        try {
            DB::beginTransaction(); // トランザクション開始

            $productId = $request->input('product_id');
            $quantity = $request->input('quantity');

            // リクエストデータのバリデーション
            $this->validate($request, [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // 商品が存在するか確認
            $product = Product::find($productId);
            if (!$product) {
                throw new \Exception('商品が見つかりません。', 404);
            }

            // 在庫が十分か確認
            if ($product->stock < $quantity) {
                throw new \Exception('在庫が不足しています。', 400);
            }

            // 購入情報をsalesテーブルに追加
            $sale = new Sale();
            $sale->product_id = $productId;
            $sale->quantity = $quantity;
            $sale->save();

            // 在庫数を減算
            $product->stock -= $quantity;
            $product->save();

            DB::commit(); // トランザクションのコミット

            return response()->json(['message' => '購入が完了しました。', 'product_id' => $productId], 200);
        } catch (ValidationException $e) {
            // バリデーションエラー
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack(); // トランザクションのロールバック

            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}



