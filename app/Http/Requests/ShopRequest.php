<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $code
 * @property mixed $name
 */
class ShopRequest extends FormRequest
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
            'code' => ['required', 'numeric'],
            'name' => ['required', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'code' => '店舗コード',
            'name' => '店舗名',
        ];
    }
}
