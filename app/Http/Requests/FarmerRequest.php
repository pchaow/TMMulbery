<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmerRequest extends FormRequest
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

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                $validator = [

                    'name' => 'required|max:255',
//                    'province_id' => 'required',
//                    'amphure_id' => 'required',
//                    'district_id' => 'required',
                ];
                if ($this->request->has('email')) {
                    $validator['email'] = 'required|email|max:255|unique:users';
                }
                if ($this->request->has('username')) {
                    $validator['username'] = 'required|max:255|unique:users';
                }
                if ($this->request->has('password')) {
                    $validator['password'] = 'required|min:6|confirmed';
                }
                return $validator;
            }
            case 'PUT':
            case 'PATCH': {
                $user = $this->get('id');

                $validator = [

                    'name' => 'required|max:255',
                    //'province_id' => 'required',
                    //'amphure_id' => 'required',
                    //'district_id' => 'required',
                ];
                if ($this->request->has('email')) {
                    if($this->request->get('email')!=null){
                        $validator['email'] = "required|email|max:255|unique:users,email,$user";
                    }
                }
                if ($this->request->has('username')) {
                    if($this->request->get('username')!=null){
                        $validator['username'] = "required|max:255|unique:users,username,$user";
                    }
                }
                if ($this->request->has('password')) {
                    $validator['password'] = 'required|min:6|confirmed';
                }
                return $validator;
            }
            default:
                break;
        }


    }
}
