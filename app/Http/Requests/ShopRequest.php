<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'title'=>'required|string|max:191',
            'logo'=>'image|nullable',
//            'address'=>'required|string|max:191',
//            'phone'=>'required|max:191',
//            'description'=>'required|string',
            'bank_account_number'=>'integer|nullable',
            'bank_account_name'=>'string|max:191||nullable',
            'commission'=>'integer|nullable',
//            'rate'=>'integer|between:0,5',
        ];
    }
}
