<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        <h1>商品情報一覧</h1>

        @include('products.search')  <!-- 検索フォームのインクルード -->

        <!-- 新規登録リンク -->
        <div class="mb-6">
            <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
        </div>

        <!-- 商品情報 -->
        @if ($productsWithCompanies->count() > 0)
            @include('livewire.product-list', ['products' => $productsWithCompanies])
        @else
            <p>No results found</p>
        @endif
    

    <!-- ページネーションリンク -->
    <div class="d-flex justify-content-center">
        {{ $productsWithCompanies->appends(request()->except('page'))->links() }}
    </div>
@endsection
