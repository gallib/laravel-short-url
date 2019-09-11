<?php

namespace Gallib\ShortUrl\Http\Requests;

use Gallib\ShortUrl\Rules\Blacklist;
use Illuminate\Foundation\Http\FormRequest;

class UrlRequest extends FormRequest
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
        $uniqueCode = '|unique:shorturl_urls';

        if ($this->route('id')) {
            $uniqueCode .= ',id,'.$this->route('id');
        }

        return [
            'url'  => ['required', 'url', new Blacklist()],
            'code' => 'max:255'.$uniqueCode,
            'expires_at' => 'date|after:now|nullable',
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        $data = parent::validationData();

        $modify = isset($data['code']) ? ['code' => \Str::slug($data['code'])] : [];

        return array_merge($data, $modify);
    }
}
