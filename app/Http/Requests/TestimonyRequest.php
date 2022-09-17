<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TestimonyRequest extends FormRequest
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
   * Prepare the data for validation.
   *
   * @return void
   *             
   * @throws \JsonException
   */
  protected function prepareForValidation(): void

{
  
    $this->merge(json_decode($this->payload, true, 512, JSON_THROW_ON_ERROR));

}
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    
        $input = $this->request->all();
        //dd($input);
    
        $rules = [
            'full_name'=>'string',
            'email'=>'required|email',
            'phone'=>'required|integer',
            'country_id'=>'required|integer',
            'city'=>'required|string',
            'content'=>'required|string',
            'file_dir'=>'required'

        ];

        if (blank($input['content']) && ( isset($input['file_dir'])  && blank($input['file_dir']))) {
            $rules["content"] = 'required|string';
            $rules["file_dir"] = 'required';
        } elseif(blank($input['content'])) {
            $rules["content"] = 'nullable|string';
            $rules["file_dir"] = 'required';
        }else{
            $rules["content"] = 'required|string';
            $rules["file_dir"] = 'nullable';
        }

        return $rules;

    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            "required" => "Required",
            "string" => "Required",
            "email" => "This email is invalid.",
            "integer" => "Choose a country.",
            "media" => "Choose a media file.",
         
        ];
    }
}
