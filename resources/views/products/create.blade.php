@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>商品新規登録</h1>

    @if($errors->any())
       <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
          </ul>
       </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="product_name" class="col-md-4 col-form-label text-md-right">商品名</label>
                    <div class="col-md-8">
                        <input type="text" name="product_name" id="product_name" class="form-control{{ $errors ->has('product_name') ? ' is-invalid' : '' }}" value="{{ old('product_name') }}">
                        @if ($errors ->has('product_name'))
                             <p>{{ $errors->first('product_name') }}</p>
                    @endif
                </div>

                <div class="form-group row">
                    <label for="company_id" class="col-md-4 col-form-label text-md-right">メーカー名</label>
                    <div class="col-md-8">
                    <select type="text" name="company_id" id="company_id" class="form-control" required>
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
                        @if($errors->has('price'))
                        <p>{{$errors->first('price') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stock" class="col-md-4 col-form-label text-md-right">在庫数</label>
                    <div class="col-md-8">
                        <input type="number" name="stock" id="stock" class="form-control" required>
                        @if($errors->has('stock'))
                        <p>{{ $errors->first('stock') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label text-md-right">商品画像</label>
                    <div class="col-md-8">
                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                        @if($errors->has('image'))
                            <p>{{ $errors->first('image') }}</p>
                            @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="comment" class="col-md-4 col-form-label text-md-right">詳細</label>
                    <div class="col-md-8">
                        <textarea name="comment" id="comment" rows="5" class="form-control" required></textarea>
                        @if($errors->has('comment'))
                        <p>{{ $errors->first('comment') }}</p>
                        @endif
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
