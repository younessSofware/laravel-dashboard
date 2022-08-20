<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'name' => 'required|unique:events|max:255',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after:date_from',
            'details' => 'required|string|min:8|max:500',
            'location' => 'required|string',
            'type' => 'required|string'
        ];
    }
}
