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

// 検索ボタンがクリックされた時の処理
$(document).off('click', '#search-button').on('click', '#search-button', function() {
    console.log('検索ボタンがクリックされました。');

    // ... (検索の処理)

    // 非同期で検索を実行
    $.ajax({
        url: '/products',
        method: 'GET',
        data: {
            column: 'id', // 仮の値、実際の値に置き換える必要があります
            order: 'asc', // 仮の値、実際の値に置き換える必要があります
            min_price: $('#min-price-input').val(),
            max_price: $('#max-price-input').val(),
            min_stock: $('#min-stock-input').val(),
            max_stock: $('#max-stock-input').val(),
            search: $('#search-input').val()
        },
        success: function(response) {
            console.log('検索リクエスト成功');
            // テーブルを再描画
            $('#product-list').html(response);
            // ソートやその他の処理を再適用
            applyTableBehaviors();
        },
        error: function(error) {
            console.error('検索リクエストエラー:', error);
        }
    });
}); 

//メーカ名を非同期に取得する関数
function loadManufacturers() {
    $.ajax({
        url: '/manufacturers',
        methed: 'GET',
        success: function(response) {
            console.log('メーカー名取得成功', response);

            //取得したメーカー名を適切な方法で表示
            displayManufacturers(response);
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
            column: column,
            order: order,
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
        error: function(error) {
            console.error('非同期リクエストエラー:', error);
        }
    });
}

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
