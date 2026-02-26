<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png'],
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['integer'],
            'status' => ['required', 'string'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力して下さい',
            'description.required' => '商品説明を入力して下さい',
            'description.max' => '商品説明を255文字以内で入力して下さい',
            'image.required' => '商品画像をアップロードして下さい',
            'image.mimes' => '商品画像は拡張子が.jpegもしくは.pngでアップロードして下さい',
            'category_ids.required' => '商品のカテゴリを選択して下さい',
            'status.required' => '商品の状態を選択して下さい',
            'price.required' => '商品価格を入力して下さい',
            'price.integer' => '商品価格を数値で入力して下さい',
            'price.min' => '商品価格を0円以上で入力して下さい',
        ];
    }
}
