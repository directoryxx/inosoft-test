<?php

namespace App\Rules;

use App\Repositories\UserRepository;
use Illuminate\Contracts\Validation\Rule;

class EmailUniqueRule implements Rule
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
        $exists = (new UserRepository)->filter(['email' => $value])->exists();

        return ! $exists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email already taken.';
    }
}
