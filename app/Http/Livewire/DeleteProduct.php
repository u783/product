<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class DeleteProduct extends Component
{
    public $productId;

    public function render()
    {
        return view('livewire.delete-product');
    }

    public function deleteProduct()
    {
        $product = Product::find($this->productId);

        if($product) {
            $product->delete();
            $this->emit('productDeleted', $this->productId);
        }
    }
}
