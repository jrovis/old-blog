<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
        switch ($this->method()) {
            // CREATE
            case 'POST':
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'required|min:2|max:255',
                    'body' => 'required|min:3',
                    'tags' => 'required',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    public function messages()
    {
        return [
            'title.required' => '请输入标题',
            'title.min' => '标题不能少于2个字符',
            'title.max' => '标题不能多于255个字符',
            'tags.required' => '请选择标签',
            'body.required' => '请输入内容',
            'body.min' => '内容不能少于3个字符',
        ];
    }
}
