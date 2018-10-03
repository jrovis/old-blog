<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => 'required|between:3,32|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,username,' . Auth::id(),
            'name' => 'between:2,32',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空。',
            'username.between' => '用户名必须介于 3 - 32 个字符之间。',
            'username.regex' => '用户名只支持中英文、数字、横杠和下划线。',
            'username.unique' => '用户名已存在。',
            'name.between'  => '称呼必须介于 2 - 32 个字符之间。',
            'email.unique' => '该邮箱已存在。',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
        ];
    }
}
