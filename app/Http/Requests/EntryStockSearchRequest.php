<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntryStockSearchRequest extends FormRequest
{
    protected $redirectRoute = 'entry_stock.index';

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
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'from_date' => '期間 開始日',
            'to_date' => '期間 終了日',
        ];
    }
}
