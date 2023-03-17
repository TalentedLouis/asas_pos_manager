<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 */
class ConfigTaxRequest extends FormRequest
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
            'tax_rate1' => ['required', 'numeric', 'between:0,100'],
            'tax_rate2' => ['required', 'numeric', 'between:0,100'],
            'started_on' => ['required', 'date'],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'tax_rate1' => '標準税率',
            'tax_rate2' => '軽減税率',
            'started_on' => '適用開始日',
        ];
    }
}
