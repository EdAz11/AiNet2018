<?php

namespace App\Http\Requests;

use App\Rules\Associated;
use App\Rules\NotMe;
use Illuminate\Foundation\Http\FormRequest;

class StoreAssociateRequest extends FormRequest
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
            'associated_user' => ['bail', 'required', 'exists:users,id', new NotMe]
        ];
    }
}
