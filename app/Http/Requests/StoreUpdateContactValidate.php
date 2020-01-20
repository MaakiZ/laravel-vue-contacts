<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FileCustonValidation;

class StoreUpdateContactValidate extends FormRequest
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
            'name'          => 'required|min:3|max:100|unique:contacts,name,{$this->id},id',
            'email'         => 'required|max:50',
            'telefone'      => 'required|max:20',
            'site'          => 'required|max:255',
            'image'         => 'image'
        ];
    }
}
