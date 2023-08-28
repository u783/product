<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 通常はここで認可のロジックを記述しますが、今回は認可を行わないため true を返します
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'manufacturer' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'details' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'name' => '商品名',
            'manufaturer' => 'メーカー名',
            'price' => '価格',
            'stock' => '在庫',
            'image' => '画像',
            'details' => '詳細',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => '商品名は必須項目です。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'manufacturer.required' => 'メーカー名は必須項目です。',
            'price.required' => '価格は必須項目です。',
            'price.numeric' => '価格は数値を入力してください。',
            'stock.required' => '在庫数は必須項目です。',
            'stock.integer' => '在庫数は整数を入力してください。',
            'image.image' => '画像は画像ファイルを選択してください。',
            'image.mimes' => '画像はjpeg、png、jpg、gif形式のファイルを選択してください。',
            'image.max' => '画像は2MB以下のファイルを選択してください。',
            'details.required' => '詳細は必須項目です。',
        ];
    }
}
