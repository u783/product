@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品検索結果</h1>

        <!-- エラーメッセージ -->
        @if(session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif

        

        <!-- 商品データを表示 -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品名</th>
                    <th>メーカー</th>
                    <th>価格</th>
                    <th>在庫数</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->company->company_name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">該当する商品はありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- ページネーションリンク -->
        {{ $products->links() }}
    </div>
@endsection