<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            'background_color' => 'required',
            'limit_color' => 'required',
            'text_color' => 'required',
            'text_size' => 'required',
            'link' => 'required|string',
            'texte' => 'required|string',
            'display' => 'required|string'
        ];
    }
}
