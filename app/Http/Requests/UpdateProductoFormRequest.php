<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoFormRequest extends FormRequest
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
            //
            'nombre'                => "required|min:3",
            'codigo'                => "required|min:3",
            'categoria'             => "required",
            'cantidad'              => "required|numeric",
            'precio_costo'          => "required|numeric",
            'precio_publico'        => "required|numeric",
            'tributo'               => "required",
            'status'                => "required",
        ];
    }
}
