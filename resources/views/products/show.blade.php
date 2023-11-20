@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品詳細</h1>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">商品名</label>
                    <input type="text" id="name" class="form-control" value="{{ $product->name }}" readonly>
                </div>

                <div class="mb-3">
                   <label for="manufacturer" class="form-label">メーカー名</label>
                @if ($product->company)
                   <input type="text" class="form-control" value="{{ $product->company->company_name }}" readonly>
                @else
                   <input type="text" class="form-control" value="関連する会社が見つかりません" readonly>
                @endif
                </div>


                <div class="mb-3">
                    <label for="price" class="form-label">価格</label>
                    <input type="number" id="price" class="form-control" value="{{ $product->price }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">在庫数</label>
                    <input type="number" id="stock" class="form-control" value="{{ $product->stock }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">商品画像</label>
                    @if($product->image)
                <img src="{{ asset($product->image) }}" alt="商品画像" class="product-image">
                @else
                <img src="{{ asset('images/default-image.jpg') }}" alt="デフォルト画像" class="product-image">
                @endif
                </div>

                <div class="mb-3">
                    <label for="details" class="form-label">詳細</label>
                    <textarea id="details" class="form-control" readonly>{{ $product->details }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">編集</a>
        </div>
    </div>

    <div class="mt-3">
            <h2>購入する</h2>
            <form method="POST" action="{{ route('purchase') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="mb-3">
                    <label for="quantity" class="form-label">数量:</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="1" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-success">購入する</button>
            </form>
        </div>
    </div>
@endsection
