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
                    <button id="search-button" type="submit" class="btn btn-primary">検索</button>
                </div>
            </div>
        </form>

        <!-- 新規登録リンク -->
        <div class="mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
        </div>

        <!-- 商品情報 -->
        @include('livewire.product-list', ['products' => $productsWithCompanies])

        <!-- ページネーションリンク -->
        <div class="d-flex justify-content-center">
            {{ $productsWithCompanies->links() }}
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            //各列のソート状態を保持するオブジェクト
            var sortStates = {};

            // ページ読み込み時にIDで降順ソートされた状態にする
            sortTable('id', 'desc');

            // テーブルヘッダーがクリックされたらソートを切り替え
            $(document).on('click', '.sortable', function() {
                var column = $(this).data('column');
                var currentOrder = $(this).data('order');
                var newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

                // ソートを実行
                sortTable(column, newOrder);

                // データ属性を更新
                $(this).data('order', newOrder);
            });

            function sortTable(column, order) {
                // ソートを行い、テーブルを更新する処理をここに実装
                console.log('Sort by ' + column + ' ' + order);
            }
        });
    </script>
@endsection
