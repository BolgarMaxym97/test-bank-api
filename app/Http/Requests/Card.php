<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Card extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @param $id
     * @return array
     */
    public function rules(): ?array
    {
        return [
            'number' => ['sometimes'],
            'user_id' => ['sometimes'],
            'pin' => ['required', 'digits:4', 'confirmed'],
        ];
    }
}
