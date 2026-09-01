<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Demo1Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
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
            'k1' => 'nullable|string',
            'k2' => 'nullable|integer',

            'title' => 'required|string',
            'content' => 'required|string',
        ];
    }
}
