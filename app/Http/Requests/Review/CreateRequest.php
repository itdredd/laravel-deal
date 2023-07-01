<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function messages()
    {
        return [
            'user_id.required' => 'A user_id is required',
            'rating.required' => 'A rating is required',
            'guarantor_id.required' => 'A guarantor_id is required',
            'review.required' => 'A review is required',
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
            'user_id' => 'required|integer',
            'rating' => 'required|between:0,5',
            'guarantor_id' => 'required|integer',
            'review' => 'required|string'
        ];
    }
}
