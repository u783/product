
<!-- 検索フォーム -->
<form action="{{ route('products.index') }}" method="GET" class="mb-3 text-center">
    @csrf
    <div class="form-row text-center" style="margin: auto;">
        <div class="form-group col-md-4 ">
            <label for="search">商品を検索</label>
            <input type="text" name="search" class="form-control" id="search" placeholder="">
        </div>
        <div class="form-group col-md-4">
            <label for="company_name">メーカー名を検索</label>
            <input type="text" name="company_name" class="form-control" id="company_name" placeholder="">
        </div>
        <div class="form-group col-md-4">
            <label for="min-price-input">最低価格</label>
            <input type="text" name="min_price" id="min-price-input" class="form-control" placeholder="">
        </div>
        <div class="form-group col-md-4">
            <label for="max-price-input">最高価格</label>
            <input type="text" name="max_price" id="max-price-input" class="form-control" placeholder="">
        </div>
        <div class="form-group col-md-4">
            <label for="min-stock-input">最低在庫数</label>
            <input type="text" name="min_stock" id="min-stock-input" class="form-control" placeholder="">
        </div>
        <div class="form-group col-md-4">
            <label for="max-stock-input">最高在庫数</label>
            <input type="text" name="max_stock" id="max-stock-input" class="form-control" placeholder="">
        </div>
        <div class="form-group col-md-4">
            <label class="invisible">検索ボタンのダミー</label>
            <div class="input-group-append">
                <button type="button" id="search-button" class="btn btn-primary">検索</button>
            </div>
        </div>
    </div>
</form>



<!-- 検索結果表示 -->
<div class="mt-4">
            @if(isset($products))
                <h2>検索結果</h2>
                <table class="table table-striped" id="product-list">
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
            @endif
        </div>
    </div>
