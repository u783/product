<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <h1>商品情報一覧</h1>

        <!-- 検索フォーム -->
        <form id="search-form" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" id="search-input" class="form-control" placeholder="商品名やメーカー名で検索">
                </div>
                <div class="col-md-4">
                    <input type="text" name="min_price" id="min-price-input" class="form-control" placeholder="最低価格">
                </div>
                <div class="col-md-4">
                    <input type="text" name="max_price" id="max-price-input" class="form-control" placeholder="最高価格">
                </div>
                <div class="col-md-4">
                    <input type="text" name="min_stock" id="min-stock-input" class="form-control" placeholder="最低在庫数">
                </div>
                <div class="col-md-4">
                    <input type="text" name="max_stock" id="max-stock-input" class="form-control" placeholder="最高在庫数">
                </div>
                <div class="col-auto">
                    <button type="button" id="search-button" class="btn btn-primary">検索</button>
                </div>
            </div>
        </form>

        <!-- 新規登録リンク -->
        <div class="mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
        </div>

        <!-- 商品情報 -->
            @if ($productsWithCompanies->count() > 0)
            @include('livewire.product-list', ['products' => $productsWithCompanies])
            @else
            <p>No results found</p>
            @endif
        </div>

        <!-- ページネーションリンク -->
        <div class="d-flex justify-content-center">
            {{ $productsWithCompanies->appends(request()->except('page'))->links() }}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
@endsection
