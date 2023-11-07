// 商品一覧を非同期で読み込む関数
function loadProducts(column = 'id', order = 'asc') {
    console.log('loadProducts() 関数が呼ばれました。');

    $.ajax({
        url: 'products', // 商品一覧を返すエンドポイントのURL
        method: 'GET',
        data: {
            column: column,
            order: order,
            min_price: $('#min-price-input').val(),
            max_price: $('#max-price-input').val(),
            min_stock: $('#min-stock-input').val(),
            max_stock: $('#max-stock-input').val(),
            search: $('#search-input').val() // 検索条件も含めて送信
        },
        success: function(response) {
            console.log('非同期リクエスト成功');
            $('#product-list').html(response);
        },
        error: function(error) {
            console.error('非同期リクエストエラー:', error);
        }
    });
}

// ページ読み込み時に商品一覧を表示
jQuery(document).ready(function($) {
    console.log('ページが読み込まれました。');
    loadProducts(); // 初期表示はID昇順で読み込む
});

// テーブルヘッダーをクリックしてソート
$('.sort').click(function(e) {
    e.preventDefault();
    console.log('テーブルヘッダーがクリックされました。');
    var column = $(this).data('column');
    var order = 'asc'; // 初期値は昇順

    // ... (ソートの処理)

    // 商品一覧を非同期で読み込む
    loadProducts(column, order);
});

// 検索ボタンがクリックされた時の処理
$('#search-button').click(function() {
    console.log('検索ボタンがクリックされました。');

    // ... (検索の処理)

    // 非同期で検索を実行
    $.ajax({
        url: '/products?search=' + searchQuery,
        method: 'GET',
        success: function(response) {
            console.log('検索リクエスト成功');
            $('#product-list').html(response);
        },
        error: function(error) {
            console.error('検索リクエストエラー:', error);
        }
    });
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
