<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 */
class PlanRequest extends FormRequest
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

    public function messages()
    {
        return [
            "prohibited_unless" =>
                "利用時間（分）を入力した場合、利用開始時間及び利用終了時間は入力できません",
        ];
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
            "use_minutes" => [
                "nullable",
                "required_without:use_start_hour,use_limit_hour",
                "integer",
                "gt:0",
            ],
            "use_start_hour" => [
                "nullable",
                "required_without:use_minutes",
                "integer",
                "between:0, 23",
                "prohibited_unless:use_minutes,null",
            ],
            "use_limit_hour" => [
                "nullable",
                "required_without:use_minutes",
                "integer",
                "between:0, 23",
                "prohibited_unless:use_minutes,null",
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            "name" => "利用プラン名",
            "use_minutes" => "利用時間(分)",
            "use_start_hour" => "利用開始時間",
            "use_limit_hour" => "利用終了時間",
        ];
    }
}
