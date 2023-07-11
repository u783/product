@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>商品新規登録</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">商品名</label>
                    <div class="col-md-8">
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="company_id" class="col-md-4 col-form-label text-md-right">メーカー名</label>
                    <div class="col-md-8">
                    <select type="text" name="manufacturer" id="manufacturer" class="form-control" required>
                            <option value="">-- 選択してください --</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label text-md-right">価格</label>
                    <div class="col-md-8">
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stock" class="col-md-4 col-form-label text-md-right">在庫数</label>
                    <div class="col-md-8">
                        <input type="number" name="stock" id="stock" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label text-md-right">商品画像</label>
                    <div class="col-md-8">
                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="details" class="col-md-4 col-form-label text-md-right">詳細</label>
                    <div class="col-md-8">
                        <textarea name="details" id="details" rows="5" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="form-group row justify-content-center">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">登録する</button>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">戻る</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
