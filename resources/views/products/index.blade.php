<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="text-center">
        <h1>商品情報一覧</h1>
    </div>
        @include('products.search')  <!-- 検索フォームのインクルード -->

        <!-- 新規登録リンク -->
        <div class="mb-6">
            <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
        </div>

        <!-- 商品情報 -->
        @livewire('product-list', ['products' => $productsWithCompanies])

    <!-- ページネーションリンク -->
    <div class="d-flex justify-content-center">
        {{ $productsWithCompanies->appends(request()->except('page'))->links() }}
    </div>
@endsection
