<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profile_image'         => ['nullable','image', 'mimes:jpg,jpeg,png'],
            'name'          => ['required', 'string', 'max:20'],
            'postcode'      => ['required', 'string', 'max:8', 'regex:/^\d{3}-\d{4}$/'],
            'address'       => ['required', 'string', 'max:255'],
            'building_name' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'profile_image.mimes'=> 'プロフィール画像は拡張子が.jpg、.jpegもしくは.pngでアップロードして下さい',
            'name.required'      => 'お名前を入力してください',
            'name.max'           => 'お名前は20文字以内で入力してください',
            'postcode.required'  => '郵便番号を入力して下さい',
            'postcode.regex'     => 'ハイフンありの８文字で入力して下さい',
            'address.required'   => '住所を入力して下さい',
        ];
    }
}
