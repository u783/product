<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public $search = '';

    protected $listeners = ['productDeleted' => 'render'];

    public function render()
    {
        $products = Product::where('product_name', 'like', '%' . $this->search . '%')
            ->orWhere('manufacturer', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.product-list', ['products' => $products]);
    }

    public function search()
    {
        // このメソッドは非同期で呼び出されます
        // 商品情報を再取得して画面をリフレッシュ
        $this->render();
    }

    public function deleteProduct($productId)
    {
        // データベースから商品を削除
        Product::destroy($productId);

        // 商品削除イベントを発行
        $this->emit('productDeleted');
    }
}
