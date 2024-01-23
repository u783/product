<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public $search = '';
    public $order = 'asc';
    public $column = 'id';

    protected $listeners = ['productDeleted' => 'render'];

    public function render()
{
    $productsWithCompanies = Product::query()
        ->where('product_name', 'like', '%' . $this->search . '%')
        ->orWhere('company_name', 'like', '%' . $this->search . '%')
        ->orderBy($this->column, $this->order)
        ->get();

    return view('livewire.product-list', [
        'productsWithCompanies' => $productsWithCompanies, // Update the variable name here
        'order' => $this->order,
        'column' => $this->column,
    ]);
}


    public function search()
    {
        $this->render();
    }

    public function deleteProduct($productId)
    {
        // データベースから商品を削除
        Product::destroy($productId);

        // 商品削除イベントを発行
        $this->emit('productDeleted');
    }

    public function sortBy($column)
    {
        // ソート対象のカラムと順序を設定
        if ($this->column === $column) {
            $this->order = ($this->order === 'asc') ? 'desc' : 'asc';
        } else {
            $this->order = 'asc';
            $this->column = $column;
        }
        $this->render();
    }
}
