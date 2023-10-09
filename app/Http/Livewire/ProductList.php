<?php

namespace App\Http\Livewire;
use App\Models\Product;

use Livewire\Component;

class ProductList extends Component
{
    public $search = '';

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('manufacturer', 'like', '%' . $this->search . '%')
            ->get();
            
        return view('livewire.product-list', ['products' => $products]);
    }
}
