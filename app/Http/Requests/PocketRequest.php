<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;

class PocketRequest extends FormRequest
{
    protected $redirect = 'api/pocket';
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
            'title' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'description' => 'regex:/^[a-zA-Z0-9\s]+$/'
        ];     
    }

    public function messages()
    {
        return [
            'title.required' => 'Please insert a valid pocket title!',
            'title.regex' => 'Please insert a alphanumeric title!',
            'description.regex' => 'Please insert a alphanumeric description!',
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
                        'message' => 'Validation error',
                        'type' => 'error',
                        'code' => 422,
                        'error' => $validator->errors()
                    ], 422);
        throw new ValidationException($validator, $response);
    }

}
