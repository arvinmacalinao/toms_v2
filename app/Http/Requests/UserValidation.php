<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Passwords\PasswordBroker;

class UserValidation extends FormRequest
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
        $id     = intval($this->route('id'));
        $item   = NULL;
        if($id > 0) {
            $item = User::find($id);
        }

        if ($id > 0) {
            $passwordRule = ['bail', 'sometimes', 'confirmed', 'max:255'];
        } else {
            $passwordRule = [
                'required',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ];
        }

        return [
			'u_fname'                   => 'bail|required|string|min:1|max:255',
            'u_mname'                   => 'bail|nullable|string|max:255',
			'u_lname'                   => 'bail|required|string|min:1|max:255',
            'rg_id'                     => 'bail|required|integer|min:0',
			'u_username'                => 'required|alpha_num|min:3|unique:to_users,u_username,' . request()->segment(3) . ',u_id',
			'u_password'                =>  $passwordRule,
			'u_position'                => 'required',
            'u_gender'                  => 'required',
            'u_signature'               => 'image',
            'r_id'                      => 'required'		
        ];
    }

    public function messages()
    {
        return [
            'u_password.regex' => 'Your password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
    }

    public function attributes()
    {
        return [
            'u_fname'           => 'First Name',
            'u_mname'           => 'Middle Name',
            'u_lname'           => 'Last Name',
            'u_username'        => 'Username',
            'u_password'        => 'Password',
            'u_position'        => 'Designation',
            'u_signature'       => 'Signature',
            'u_gender'          => 'Gender',
            'r_id'              => 'Role',
            'rg_id'             => 'Region'
        ];
    }
}
