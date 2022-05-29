<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * @property mixed|string user_type
 */
class LoginRequest extends FormRequest
{
    protected $loginField;
    protected $loginValue;

    protected function prepareForValidation()
    {
//    $this->loginField = filter_var($this->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'school_id';

//    login with email or id or phone number
        if (filter_var($this->input('login'), FILTER_VALIDATE_EMAIL)) {
            $this->loginField = 'email';

        } elseif (filter_var($this->input('login'), FILTER_VALIDATE_INT)) {
            $this->loginField = 'phone_number';

        } else {
            $this->loginField = 'school_id';
        }

        $this->loginValue = $this->input('login');
        $this->merge([$this->loginField => $this->loginValue]);
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required_without_all:school_id,phone_number|string|email|max:255',
            'school_id' => 'required_without_all:email,phone_number|string',
            'phone_number' => 'required_without_all:school_id,email',
            'password' => 'required',
//      'user_type' => 'required'
        ];
    }

    public function authenticate()
    {
        if (!Auth::attempt($this->only($this->loginField, 'password'), $this->filled('remember'))) {
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }
    }
}
