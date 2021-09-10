<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
  protected $loginField;
  protected $loginValue;

  protected function prepareForValidation()
  {
    $this->loginField = filter_var($this->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'staff_id';
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
      'email' => 'required_without:staff_id|string|email|max:255',
      'staff_id' => 'required_without:email|string',
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
