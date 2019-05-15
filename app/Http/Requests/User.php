<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @param $id
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                {
                    return [
                        'name_first' => ['required'],
                        'name_last' => ['required'],
                        'phone' => ['required', 'numeric'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->id],
                        'password' => ['required', 'min:6', 'confirmed']
                    ];
                }
            case 'PUT':
                {
                    return [
                        'name_first' => ['required'],
                        'name_last' => ['required'],
                        'phone' => ['required', 'numeric'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->id],
                        'password' => ['sometimes', 'min:6', 'confirmed']
                    ];
                }
            default:
                return [];
        }
    }
}
