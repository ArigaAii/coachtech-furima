<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method' => ['required', 'in:card,convenience'],
            //配送先選択必須をここに追加する
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => '支払い方法を選択して下さい',
        ];
    }
}
