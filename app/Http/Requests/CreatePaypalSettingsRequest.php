<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaypalSettingsRequest extends FormRequest {

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
            'paypal_mode' => 'required', 
            'paypal_api_username' => 'required', 
            'paypal_api_password' => 'required', 
            'paypal_api_signature' => 'required', 
            'paypal_app_id' => 'required', 
            
		];
	}
}
