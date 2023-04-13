<?php

namespace App\Http\Requests;

use Facade\Ignition\Views\Compilers\BladeSourceMapCompiler;
use Illuminate\Foundation\Http\FormRequest;

class VettedTestimonyRequest extends FormRequest
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
        $input = $this->request->all();
        $rules = [
            'name' => 'required|string',

            'country' => 'required|string',
            'city' => 'required|string',
            'content' => 'required|string',
            'file_dir' => 'required',
        ];

        if ((blank($input['content'] && (isset($input['file_dir'])) && blank($input['file_dir'])))) {

            $rules['content'] = 'required';
            $rules["file_dir"] = 'required';
        } elseif (blank($input['content'])) {

            $rules['content'] = 'nullable';
            $rules['file_dir'] = 'required';
        } else {
            $rules["content"] = 'required';
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
