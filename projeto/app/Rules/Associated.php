<?php

namespace App\Rules;

use App\AssociateMember;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class Associated implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return empty(AssociateMember::find(Auth::id())->where('associated_user_id', $value)->get());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cannot be associated.';
    }
}
