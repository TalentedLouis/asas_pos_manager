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
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // TODO Make validation rules
        return [
            'staff_id' => ['required', 'integer'],
            'supplier_target_id' => ['required', 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'staff_id' => '担当者No.',
            'supplier_target_id' => '仕入先No.',
        ];
    }
}
