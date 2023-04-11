<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopConfigRequest extends FormRequest
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
        return [
            'delay_minutes' => ['required', 'integer'],
            'exit_reserve_minutes' => ['required', 'integer'],
            'slip_number_sequence' => ['required', 'integer'],
            'trans_date' => ['required', 'date'],
        ];
    }

    public function attributes()
    {
        return [
            'delay_minutes' => '延長時間(分)',
            'exit_reserve_minutes' => '退室予備時間(分)',
            'slip_number_sequence' => '伝票番号 連番',
            'trans_date' => '処理日付',

        ];
    }
}
