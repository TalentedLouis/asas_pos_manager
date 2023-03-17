<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name' => ['string', 'required'],
            'address' => ['string', 'required'],
            'telephone' => ['string', 'required'],
            'text_1' => ['string', 'nullable'],
            'text_2' => ['string', 'nullable'],
            'text_3' => ['string', 'nullable'],
            'text_4' => ['string', 'nullable'],
            'text_5' => ['string', 'nullable'],
            'header_image_file' => [
                'image',
                'file',
                'nullable',
                'mimes:png,jpg,jpeg,gif,bmp',
                'max:500',
            ],
            'footer_image_file' => [
                'image',
                'file',
                'nullable',
                'mimes:png,jpg,jpeg,gif,bmp',
                'max:500',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => '店名',
            'address' => '住所',
            'telephone' => '電話番号',
            'text_1' => 'フリーメッセージ１',
            'text_2' => 'フリーメッセージ２',
            'text_3' => 'フリーメッセージ３',
            'text_4' => 'フリーメッセージ４',
            'text_5' => 'フリーメッセージ５',
            'header_image_file' => 'ヘッダー画像',
            'footer_image_file' => 'フッター画像',
        ];
    }
}
