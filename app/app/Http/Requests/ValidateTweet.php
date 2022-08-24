<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateTweet extends FormRequest
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
            'text' => ['required', 'string', 'max:140']
        ];
    }

    /**
     * バリデーションメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'text.required' => '文章を入力してください',
            'text.string'   => 'string型で入力してください',
            'text.max'      => '140文字以内で入力してください'
        ];
    }
}
