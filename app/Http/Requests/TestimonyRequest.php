<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        dd($this->request->all());
        $input = $this->request->all();
    
        $rules = [
            'full_name'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|string',
            'country_id'=>'required|integer',
            'city'=>'required|string',
            'content'=>'required|string',
            'file_dir'=>'required',
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
