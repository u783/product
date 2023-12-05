@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品編集</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="product_name" class="form-label">商品名</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" value="{{ $product->product_name }}" required>
                    </div>

                    <div class="mb-3">
                       <label for="company_id" class="form-label">メーカー名</label>
                       <select name="company_id" id="company_id" class="form-control" required>
                    <option value="">-- 選択してください --</option>
                        @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ $company->id == $company->id ? 'selected' : '' }}>
                       {{ $company->company_name }}
                    </option>
                       @endforeach
                    </select>
                  </div>


                    <div class="mb-3">
                        <label for="price" class="form-label">価格</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">在庫数</label>
                        <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">商品画像</label>
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" alt="商品画像" class="product-image">
                        @else
                            <img src="{{ asset('images/default-image.jpg') }}" alt="デフォルト画像" class="product-image">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="new_image" class="form-label">新しい画像</label>
                        <input type="file" name="new_image" id="new_image" class="form-control-file" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="details" class="form-label">詳細</label>
                        <textarea name="comment" id="comment" rows="5" class="form-control" required>{{ $product->details }}</textarea>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">更新する</button>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
