<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\User;

class RegisterRequest extends FormRequest
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
        return User::getRegisterValidationRulesArray( []  );
    }

    public function messages()
    {
        return [
            'login.required' => 'Please enter user login',
            'login.unique' => 'Please enter unique login',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter email in valid format',
            'email.unique' => 'Please enter unique email',
            'password.min' => 'Password must be at least 6 chars',
            'password.same' => 'Password must be equal Confirm password',
            'cpassword.min' => 'Password must be at least 6 chars',
        ];
    }
}
