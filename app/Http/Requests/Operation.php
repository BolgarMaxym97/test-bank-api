<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Operation extends FormRequest
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
                        'card_id' => ['required'],
                        'pin' => ['required', 'digits:4'],
                        'operation_type_id' => ['required'],
                        'additional_info' => ['sometimes', 'string', 'max:255'],
                        'card_number' => ['sometimes'],
                        'amount' => ['required', 'numeric', 'min:0'],
                    ];
                }
            case 'PUT':
                {
                    return [
                        'operation_type_id' => ['required'],
                        'pin' => ['required', 'digits:4'],
                        'amount' => ['required', 'numeric'],
                        'card_number' => ['sometimes'],
                        'additional_info' => ['sometimes', 'string', 'max:255'],
                    ];
                }
            default:
                return [];
        }
    }
}
