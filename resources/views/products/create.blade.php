@extends('layouts.app')

@section('content')
<div class="container text-center">
        <h1>商品新規登録</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">商品名</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="manufacturer">メーカー名</label>
                        <input type="text" name="manufacturer" id="manufacturer" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="price">価格</label>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="stock">在庫数</label>
                        <input type="number" name="stock" id="stock" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="image">商品画像</label>
                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="details">詳細</label>
                        <textarea name="details" id="details" rows="5" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">登録する</button>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>
                </form>
            </div>
        </div>
    </div>
@endsection


