<?php

namespace App\Http\Requests;

use App\Rules\ExceptZero;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMovementRequest extends FormRequest
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
            'movement_category_id' => 'required|exists:movement_categories,id',
            'date' => 'required|date',
            'value' => ['required', 'numeric', new ExceptZero],
            'description' => 'nullable',
            'document_file' => 'nullable|mimes:pdf,png'
        ];
    }
}
