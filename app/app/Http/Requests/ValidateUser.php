<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateUser extends FormRequest
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
        $user=auth()->user();
        return [
            'screen_name'   => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'name'          => ['required', 'string', 'max:20'],
            'profileImage' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
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
            'screen_name.required'  => 'アカウント名を入力してください',
            'screen_name.string'    => 'string型で入力してください',
            'screen_name.max'       => 'アカウント名は20文字以内で入力してください',
            'screen_name.unique'    => 'このアカウント名は既に使われています',
            'name.required'         => '名前を入力してください',
            'name.string'           => 'string型で入力してください',
            'name.max'              => '名前は20文字以内で入力してください',
            'profileImage.file'     => 'ファイルで入力してください', 
            'profileImage.image'    => '画像を入力してください',
            'profileImage.mimes'    => '画像の拡張子はjpeg,png,jpgのみ許可されています',
            'profileImage.max'      => '画像サイズが大きすぎます（2MB以内です）',
            'email.required'        => 'メールアドレスを入力してください',
            'email.string'          => 'string型で入力してください',
            'email.email'           => 'メールアドレスを入力してください',
            'email.max'             => 'メールアドレスは255文字以内で入力してください',
            'email.unique'          => 'このメールアドレスは既に使われています'
        ];
    }
}
