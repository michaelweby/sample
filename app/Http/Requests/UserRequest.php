<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    protected $redirect = 'users';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function response(array $errors){
        return \Redirect::back()->withErrors($errors)->withInput();
    }

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
            'email' => 'required|unique:users|email',
            'username'=>'required|unique:users',
            'phone'=>'required',
            'password'=>'required|confirmed',
            'first_name'=>'required',
            'last_name'=>'required',
            'gender' => 'required',
            'birthday' => 'required',
        ];
    }
}
