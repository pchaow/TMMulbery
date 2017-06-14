<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantTransactionStatusRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|unique:plant_transaction_statuses,name|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                $id = $this->get('id');

                return [
                    'name' => "required|unique:plant_transaction_statuses,name,$id|max:255",
                ];
            }
            default:break;
        }

    }
}
