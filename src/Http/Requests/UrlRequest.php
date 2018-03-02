<?php

namespace Gallib\ShortUrl\Http\Requests;

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

        if ($this->get('id')) {
            $uniqueCode .= ',id,'.$this->get('id');
        }

        $codeNotIn = config('shorturl.route_form_prefix') ? '|not_in:'.config('shorturl.route_form_prefix') : '';

        return [
            'url'  => 'required|url',
            'code' => 'max:255'.$uniqueCode.$codeNotIn,
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        $data = parent::validationData();

        $modify = isset($data['code']) ? ['code' => str_slug($data['code'])] : [];

        return array_merge($data, $modify);
    }
}
