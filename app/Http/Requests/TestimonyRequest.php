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
        return [
            'full_name'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|string',
            'country_id'=>'required|integer',
            'city'=>'required|string',
            'content'=>'required|string',
            'file_dir'=>'required|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi',
        ];
    }

    public function messages()
    {
        return [
            "required" => "Ce champ est obligatoire.",
            "string" => "Ce champ est obligatoire.",
            "email" => "Renseignez un email valide.",
            "integer" => "Choisissez un pays.",
            "mimetypes" => "Choisissez une vidéo.",
        ];
    }
}
