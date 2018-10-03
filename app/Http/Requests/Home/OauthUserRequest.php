<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class OauthUserRequest extends FormRequest
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
            'github_id' => 'unique:users',
            'github_name' => 'string',
            'wechat_openid' => 'string',
            'username' => 'alpha_num|required|between:3,32|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,username,' . Auth::id(),
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'github_url' => 'url',
            'image_url' => 'url',
            'wechat_unionid' => 'string',
            'password' => 'required|confirmed|min:6',
            'name' => 'between:2,32',
        ];
    }
}
