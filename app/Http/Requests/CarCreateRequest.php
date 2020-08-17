<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class CarCreateRequest extends FormRequest
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
            'make' => 'required|min:3',
            'model' => 'required|min:3',
            'year' => 'required|integer|max:' . (Carbon::now()->parse('Y')),
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }
}
