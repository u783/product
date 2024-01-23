$(document).ready(function () {
    // テーブルヘッダーをクリックしてソート
    $(document).on('click', '.sortable', function () {
        var column = $(this).data('column');
        var currentOrder = $(this).data('order');
        var newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

        // ソートの処理
        sortTable(column, newOrder);

        $(this).data('order', newOrder);

    });

    // 検索ボタンがクリックされたときの非同期処理
    $(document).on('click', '#search-button', function (event) {
        event.preventDefault(); // フォームのデフォルトの送信を防ぐ
        console.log('検索ボタンがクリックされました。');
        searchProducts();
    });

    applyTableBehaviors();
});

// ソートを行い、テーブルを更新する処理
function sortTable(column, order) {
    console.log('Sort by ' + column + ' ' + order);
    
    $.ajax({
        url: '/products',
        method: 'GET',
        success: function (response) {
            console.log('非同期リクエスト成功');
            // テーブルを再描画
            $('#product-list').html(response);
            // ソートやその他の処理を再適用
            applyTableBehaviors();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('非同期リクエストエラー:', textStatus, errorThrown);
        }
    });
}

// 検索を実行する関数
function searchProducts() {
    var searchInput = ($('#search-input').val() || '').trim();
    var companyInput = ($('#company_name').val() || '').trim();
    var minPrice = ($('#min-price-input').val() || '').trim();
    var maxPrice = ($('#max-price-input').val() || '').trim();
    var minStock = ($('#min-stock-input').val() || '').trim();
    var maxStock = ($('#max-stock-input').val() || '').trim();

    $.ajax({
        url: '/products/search',
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            search: searchInput,
            company_name: companyInput,
            min_price: minPrice,
            max_price: maxPrice,
            min_stock: minStock,
            max_stock: maxStock
        },
        success: function (response) {
            $('#product-list').html(response);
            applyTableBehaviors();
        },
        error: function (xhr, status, error) {
            console.error('非同期リクエストエラー:', status, error);

            if (xhr.status === 404) {
                alert('リクエストされたリソースが見つかりません。');
            } else if (xhr.status === 500) {
                alert('サーバーエラーが発生しました。');
            } else {
                alert('検索中にエラーが発生しました。もう一度試してください。 \nエラー詳細: ' + error);
            }
        }
    });
}

// 商品を削除する関数
function deleteProduct(productId) {
    console.log('商品削除ボタンがクリックされました.');

    var confirmation = confirm('商品を削除しますか？');
    console.log('Confirmation', confirmation);

    if (confirmation) {
        $.ajax({
            url: '/products/' + productId,
            type: 'POST',
            data: { '_method': 'DELETE', '_token': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                console.log('商品削除リクエスト成功', response);
                if (response.success) {
                    alert('削除が成功しました。');
                    location.reload();
                } else {
                    alert('削除に失敗しました。' + response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('商品削除リクエストエラー', textStatus, errorThrown);
                alert('削除に失敗しました。');
            }
        });
    } else {
        console.log('削除キャンセル');
        // キャンセルが選択された場合は何もしない
    }
}

// テーブルに関連する処理を再適用する関数
function applyTableBehaviors() {
    // ソートやその他の処理をここに記述
    // 例: テーブルヘッダーをクリックしてソートする処理
    $(document).off('click', '.sort').on('click', '.sort', function (e) {
        e.preventDefault();
        console.log('テーブルヘッダーがクリックされました。');
        var column = $(this).data('column');
        var order = 'asc';

        // ... (ソートの処理)

        // 商品一覧を非同期で読み込む
        sortTable(column, order);
    });
}
