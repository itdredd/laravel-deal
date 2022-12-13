<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealPostRequest extends FormRequest
{
    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'description.required' => 'A description is required',
            'value.required' => 'A value is required',
            'currency.required' => 'A currency is required',
            'members_id.required' => 'A members is required',
        ];
    }


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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'value' => 'required',
            'currency' => 'required',
            'members_id' => 'required',
        ];
    }
}
