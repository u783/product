<!-- resources/views/products/search.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品検索結果</h1>

    <!-- 商品データを表示 -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>メーカー</th>
                <th>価格</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->manufacturer }}</td>
                    <td>{{ $product->price }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">該当する商品はありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
