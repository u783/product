//resources>js>products.js
// 商品一覧を非同期で読み込む関数
function loadProducts(column = 'id', order = 'asc') {
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
            $('#product-list').html(response);
        },
        error: function(error) {
            console.error(error);
        }
    });
}

// ページ読み込み時に商品一覧を表示
$(document).ready(function() {
    loadProducts(); // 初期表示はID昇順で読み込む
});

// テーブルヘッダーをクリックしてソート
$('.sort').click(function(e) {
    e.preventDefault();
    var column = $(this).data('column');
    var order = 'asc'; // 初期値は昇順

    // 現在のソート状態を取得
    var currentColumn = $(this).data('current-column');
    var currentOrder = $(this).data('current-order');

    // クリックされたカラムが現在のソートカラムであれば、ソート順を切り替える
    if (column === currentColumn) {
        order = currentOrder === 'asc' ? 'desc' : 'asc';
    }

    // ソートリンクのデータ属性を更新
    $('.sort').data('current-column', column);
    $('.sort').data('current-order', order);

    // テーブルヘッダーに選択中のカラムを表示
    $('.sort').removeClass('selected');
    $(this).addClass('selected');

    // 商品一覧を非同期で読み込む
    loadProducts(column, order);
});

// 検索ボタンがクリックされた時の処理
$('#search-button').click(function() {
    // 検索条件を取得
    var searchQuery = $('#search-input').val();

    // 非同期で検索を実行
    $.ajax({
        url: '/products?search=' + searchQuery,
        method: 'GET',
        success: function(response) {
            // 検索結果を表示する処理
            $('#product-list').html(response);
        },
        error: function(error) {
            console.error(error);
        }
    });
});

// 商品を削除する関数
function deleteProduct(productId) {
    if (confirm('商品を削除しますか？')) {
        $.ajax({
            url: '/products/' + productId, // 商品IDを含むURL
            type: 'DELETE', // DELETEリクエストを送信
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRFトークンを含める
            },
            success: function (response) {
                if (response.success) {
                    // 成功した場合、該当の行を非表示にする
                    $('#product-row-' + productId).hide();
                } else {
                    alert('削除に失敗しました。');
                }
            },
            error: function () {
                alert('削除に失敗しました。');
            }
        });
    }
}
