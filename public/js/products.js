// ページ読み込み時に商品一覧を表示
$(document).ready(function() {
    loadProducts();
    applyTableBehaviors(); // 追加: 初回読み込み時にも適用


    sortTable('id', 'desc');

// テーブルヘッダーをクリックしてソート
$(document).on('click', '.sortable', function() {
    var column = $(this).date('column');
    var currentOrder = $(this).date('order');
    var newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

    // (ソートの処理)
    sortTable(column, newOrder);

    //データ属性を更新
    $(this).date('order', newOrder);
});

// 検索ボタンがクリックされたときの非同期処理
$('#search-button').on('click', function() {
    searchProducts();
});

applyTableBehaviors();
});

// ソートを行い、テーブルを更新する処理
function sortTable(column, order) {
    console.log('Sort by ' + column + ' ' + order);
    // ここにソートのための処理を実装
    // ...
}
// 検索を実行する関数
function searchProducts() {
    // 検索条件の取得
    var searchInput = $('#search-input').val().trim();
    var companyInput = $('#company-input').val().trim();
    var minPrice = $('#min-price-input').val().trim();
    var maxPrice = $('#max-price-input').val().trim();
    var minStock = $('#min-stock-input').val().trim();
    var maxStock = $('#max-stock-input').val().trim();

    // 以下、非同期処理を実行し、結果をもとに商品一覧を更新するコード
    // ...

    // 例として、ダミーの非同期処理を実行してみます
    $.ajax({
        url: "{{ route('products.search') }}",
        method: "GET",
        data: {
            search: searchInput,
            company_name: companyInput,
            min_price: minPrice,
            max_price: maxPrice,
            min_stock: minStock,
            max_stock: maxStock
        },
        success: function(response) {
            // 商品一覧を更新
            $('#product-list').html(response);
        },
        error: function(xhr, status, error) {
            console.error('非同期リクエストエラー:', status, error);

            //ユーザーにエラー表示
            alert('検索中にエラーが発生しました。もう一度試してください。')
        }
    });
}


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

            
        
// 商品を削除する関数
function deleteProduct(productId) {
    console.log('商品削除ボタンがクリックされました。');

    var confirmation = confirm('商品を削除しますか？');
    console.log('Confirmation', confirmation);

    if (confirmation) {
        $.ajax({
            url: '/products/' + productId,
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                console.log('商品削除リクエスト成功', response);
                if (response.success) {
                    alert('削除が成功しました。');
                    location.reload();
                } else {
                    alert('削除に失敗しました。' + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
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
    $(document).off('click', '.sort').on('click', '.sort', function(e) {
        e.preventDefault();
        console.log('テーブルヘッダーがクリックされました。');
        var column = $(this).data('column');
        var order = 'asc';

        // ... (ソートの処理)

        // 商品一覧を非同期で読み込む
        loadProducts(column, order);
    });
}
