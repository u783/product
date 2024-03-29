<!-- product-list.blade.php -->

<div class="table-responsive" id="product-list">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><a href="{{ route('products.index', ['column' => 'id', 'order' => ($column ==='id' && $order === 'asc') ? 'desc' : 'asc']) }}">ID</a></th>                
                <th><a href="{{ route('products.index', ['column' => 'image', 'order' => 'asc']) }}">商品画像</a></th>
                <th><a href="{{ route('products.index', ['column' => 'product_name', 'order' => 'asc']) }}">商品名</a></th>
                <th><a href="{{ route('products.index', ['column' => 'price', 'order' => ($column === 'price' && $order === 'asc') ? 'desc' : 'asc']) }}">価格</a></th>
                <th><a href="{{ route('products.index', ['column' => 'stock', 'order' => ($column === 'stock' && $order === 'asc') ? 'desc' : 'asc']) }}">在庫数</a></th>
                <th><a href="{{ route('products.index', ['column' => 'company_name', 'order' => 'asc']) }}">メーカー名</a></th>
                <th><a href="{{ route('products.index', ['column' => 'comment', 'order' => 'asc']) }}">詳細</a></th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
        @foreach($productsWithCompanies as $product)                 <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="product-image">
                        @else
                            <img src="{{ asset('images/default-image.jpg') }}" alt="デフォルト画像" class="product-image">
                        @endif
                    </td>
                    <td style="text-align:center">{{ $product->product_name }}</td>
                    <td style="text-align:center">{{ $product->price }}</td>
                    <td style="text-align:center">{{ $product->stock }}</td>
                    <td style="text-align:center">{{ optional($product->company)->company_name }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>
                    </td>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="deleteProduct('{{ $product->id }}')" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
