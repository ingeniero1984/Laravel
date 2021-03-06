<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SaveProjectRequest extends FormRequest
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
            
            'title'       => 'required',
            'url'         => ['required',Rule::unique('projects')->ignore($this->route('project'))],
            'description' => 'required',
            'image'       => [
                            $this->route('project') ? 'nullable' : 'required',
                            'mimes:png,jpeg,jpg',
                        ],

        ];
    }

    public function messages()
    {
        return [

            'title.required'       => 'Añade un título al proyecto',
            'url.required'         => 'Añade una url ej: mi-nuevo-proyecto',
            'description.required' => 'Añade una descripción a tu proyecto',
            'image.required'     => 'Agrega una imagen de tu proyecto',

        ];

    }

    /**
     * Preparar para validación
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'url' => Str::lower($this->url)
        ]);
    }
}
