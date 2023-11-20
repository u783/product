<!-- product-list.blade.php -->

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><a href="{{ route('products.index', ['column' => 'id', 'order' => 'asc']) }}">ID</a></th>                
                <th><a href="{{ route('products.index', ['column' => 'image', 'order' => 'asc']) }}">商品画像</a></th>
                <th><a href="{{ route('products.index', ['column' => 'name', 'order' => 'asc']) }}">商品名</a></th>
                <th><a href="{{ route('products.index', ['column' => 'price', 'order' => 'asc']) }}">価格</a></th>
                <th><a href="{{ route('products.index', ['column' => 'stock', 'order' => 'asc']) }}">在庫数</a></th>
                <th><a href="{{ route('products.index', ['column' => 'company.name', 'order' => 'asc']) }}">メーカー名</a></th>
                <th><a href="{{ route('products.index', ['column' => 'details', 'order' => 'asc']) }}">詳細</a></th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="product-image">
                        @else
                            <img src="{{ asset('images/default-image.jpg') }}" alt="デフォルト画像" class="product-image">
                        @endif
                    </td>
                    <td style="text-align:center">{{ $product->name }}</td>
                    <td style="text-align:center">{{ $product->price }}</td>
                    <td style="text-align:center">{{ $product->stock }}</td>
                    <td style="text-align:center">{{ $product->company_name }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>
                    </td>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
