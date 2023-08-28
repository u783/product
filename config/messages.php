<?php

return [
    'update_success' => '商品が更新されました。',
    'update_error' => '商品の更新に失敗しました。',
    'store_success' =>'商品が登録されました。',
    'delete_success' => '商品が削除されました。',
];

return [
    'name' => 'required|string|max:255',
            'manufacturer' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'details' => 'required',
];

