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
    <form action="{{ route('products.search') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="商品名やメーカー名で検索">
            </div>
            <div class="col-md-4">
            <input type="text" name="min_price" class="form-control" placeholder="最低価格">
        </div>
        <div class="col-md-4">
            <input type="text" name="max_price" class="form-control" placeholder="最高価格">
        </div>
        <div class="col-md-4">
            <input type="text" name="min_stock" class="form-control" placeholder="最低在庫数">
        </div>
        <div class="col-md-4">
            <input type="text" name="max_stock" class="form-control" placeholder="最高在庫数">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </div>
    </form>

    <!-- 新規登録リンク -->
    <div class="mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
    </div>

    <!-- 商品情報 -->
    <div class="table-responsive">
        <table class="table table-striped">
            <!-- テーブルヘッダーの設定 -->
            <thead>
                <tr>
                    <th><a href="#" class="sort" data-column="id">ID</a></th>
                    <th><a href="#" class="sort" data-column="image">商品画像</a></th>
                    <th><a href="#" class="sort" data-column="name">商品名</a></th>
                    <th><a href="#" class="sort" data-column="price">価格</a></th>
                    <th><a href="#" class="sort" data-column="stock">在庫数</a></th>
                    <th><a href="#" class="sort" data-column="company_name">メーカー名</a></th>
                    <th>詳細</th>
                    <th>削除</th>
                </tr>
            </thead>
            <!-- 商品データの表示 -->
            <tbody id="product-list">
                @foreach($productsWithCompanies as $product)
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

    <!-- ページネーションリンク -->
    <div class="d-flex justify-content-center">
        {{ $productsWithCompanies->links() }}
    </div>
</div>
@endsection
