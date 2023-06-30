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
        <form action="{{ route('products.index') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="商品名やメーカー名で検索">
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
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>メーカー名</th>
                        <th>詳細</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
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
                            <td style="text-align:center">{{ $product->manufacturer }}</td>
                            <td style="text-align:center">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary">詳細</a>
                            </td>

                            <td>
                                <form action="{{ route('products.destroy', $product) }}" method="POST">
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
            {{ $products->links() }}
        </div>
    </div>
@endsection


