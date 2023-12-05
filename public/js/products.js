// ページ読み込み時に商品一覧を表示
$(document).ready(function() {
    loadProducts();
    applyTableBehaviors(); // 追加: 初回読み込み時にも適用
});

// テーブルヘッダーをクリックしてソート
$(document).off('click', '.sort').on('click', '.sort', function(e) {
    e.preventDefault();
    console.log('テーブルヘッダーがクリックされました。');
    var column = $(this).data('column');
    var order = 'asc';

    // ... (ソートの処理)

    // 商品一覧を非同期で読み込む
    loadProducts(column, order);
});



//メーカ名を非同期に取得する関数
function loadCompany_id() {
    $.ajax({
        url: '/company_id',
        method: 'GET',
        success: function(response) {
            console.log('メーカー名取得成功', response);

            //取得したメーカー名を適切な方法で表示
            displayCompany_id(response);
        },
        error: function(error) {
            console.error('メーカー名取得エラー', error);

        }
    });
}

// 商品一覧を非同期で読み込む関数
function loadProducts(column = 'id', order = 'asc') {
    console.log('loadProducts() 関数が呼ばれました。');

    $.ajax({
        url: '/products',
        method: 'GET',
        data: {
            min_price: $('#min-price-input').val(),
            max_price: $('#max-price-input').val(),
            min_stock: $('#min-stock-input').val(),
            max_stock: $('#max-stock-input').val(),
            search: $('#search-input').val()
        },
        success: function(response) {
            console.log('非同期リクエスト成功');
            // テーブルを再描画
            $('#product-list').html(response);
            // ソートやその他の処理を再適用
            applyTableBehaviors();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('非同期リクエストエラー:', textStatus, errorThrown);
        }
    });
}

        $(document).ready(function() {
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

            // 検索ボタンがクリックされたときの非同期処理
            $('#search-button').on('click', function() {
                searchProducts();
            });

            // 検索を実行する関数
            function searchProducts() {
                // 検索条件の取得
                var searchInput = $('#search-input').val();
                var minPrice = $('#min-price-input').val();
                var maxPrice = $('#max-price-input').val();
                var minStock = $('#min-stock-input').val();
                var maxStock = $('#max-stock-input').val();

                // 以下、非同期処理を実行し、結果をもとに商品一覧を更新するコード
                // ...

                // 例として、ダミーの非同期処理を実行してみます
                $.ajax({
                    url: "{{ route('products.search') }}",
                    method: "GET",
                    data: {
                        search: searchInput,
                        min_price: minPrice,
                        max_price: maxPrice,
                        min_stock: minStock,
                        max_stock: maxStock
                    },
                    success: function(response) {
                        // 商品一覧を更新
                        $('#product-list').html(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            // ソートを行い、テーブルを更新する処理
            function sortTable(column, order) {
                console.log('Sort by ' + column + ' ' + order);
                // ここにソートのための処理を実装
                // ...
            }
        });

// 商品を削除する関数
function deleteProduct(productId) {
    console.log('商品削除ボタンがクリックされました。');
    if (confirm('商品を削除しますか？')) {
        $.ajax({
            url: '/products/' + productId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('商品削除リクエスト成功');
                if (response.success) {
                    $('#product-row-' + productId).hide();
                } else {
                    alert('削除に失敗しました。');
                }
            },
            error: function() {
                console.error('商品削除リクエストエラー');
                alert('削除に失敗しました。');
            }
        });
    }
}

// テーブルに関連する処理を再適用する関数
function applyTableBehaviors() {
    // ソートやその他の処理をここに記述
    // 例: テーブルヘッダーをクリックしてソートする処理
    $(document).off('click', '.sort').on('click', '.sort', function(e) {
        e.preventDefault();
        console.log('テーブルヘッダーがクリックされました。');
        var column = $(this).data('column');
        var order = 'asc';

        // ... (ソートの処理)

        // 商品一覧を非同期で読み込む
        loadProducts(column, order);
    });

    // 他のテーブルに関連する処理も同様に記述
}
