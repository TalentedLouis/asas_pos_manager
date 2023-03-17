<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 */
class RoomRequest extends FormRequest
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
            "name" => ["required", "string"],
            "type_id" => ["required", "string"],
            "smoking_type_id" => ["required", "integer"],
            "pc_type_id" => ["required", "integer"],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            "name" => "部屋名",
            "type_id" => "部屋タイプ",
            "smoking_type_id" => "喫煙タイプ",
            "pc_type_id" => "PCタイプ",
        ];
    }
}
