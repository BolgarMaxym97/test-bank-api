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
        switch ($this->method()) {
            case 'POST':
                {
                    return [
                        'number' => ['required', 'numeric'],
                        'user_id' => ['required'],
                        'pin' => ['required'],
                        'amount' => ['required', 'numeric'],
                    ];
                }
            case 'PUT':
                {
                    return [
                        'number' => ['sometimes', 'numeric'],
                        'user_id' => ['sometimes'],
                        'pin' => ['sometimes'],
                        'amount' => ['required', 'numeric'],
                    ];
                }
            default:
                return [];
        }
    }
}
