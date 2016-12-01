<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionsRequest extends FormRequest {

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
            'gateway_name' => 'required', 
            'user_id' => 'required', 
            'amount' => 'numeric|required', 
            'transation_id' => 'required', 
            'status' => 'required', 
            'type' => 'required', 
            
		];
	}
}
