@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品詳細変更</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">商品名</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="manufacturer">メーカー名</label>
                        <input type="text" name="manufacturer" id="manufacturer" class="form-control" value="{{ $product->manufacturer }}" required>
                    </div>

                    <div class="form-group">
                        <label for="price">価格</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                    </div>

                    <div class="form-group">
                        <label for="stock">在庫数</label>
                        <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
                    </div>

                    <div class="form-group">
                        <label for="image">商品画像</label>
                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" alt="商品画像" class="product-image">
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="details">詳細</label>
                        <textarea name="details" id="details" rows="5" class="form-control" required>{{ $product->details }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">変更する</button>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>
                </form>
            </div>
        </div>
    </div>
@endsection
