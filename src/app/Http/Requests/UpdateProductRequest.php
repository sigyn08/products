<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // 必要に応じて認可ロジックを追加
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'price' => ['required', 'numeric', 'between:0,10000'],
            'season' => ['required', 'array', 'min:1'],
            'description' => ['required', 'max:120'],
            'image' => ['nullable', 'file', 'mimes:png,jpeg'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'season.required' => '季節を選択してください',
            'season.array' => '季節を選択してください',
            'season.min' => '季節を選択してください',
            'season.*.in' => '季節の値が正しくありません',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
