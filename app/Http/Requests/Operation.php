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
                        'user_id' => ['required'],
                        'card_id' => ['required'],
                        'operation_type_id' => ['required'],
                        'is_success' => ['required', 'boolean'],
                        'additional_info' => ['sometimes', 'string', 'max:255'],
                        'amount' => ['required', 'numeric'],
                    ];
                }
            case 'PUT':
                {
                    return [
                        'operation_type_id' => ['required'],
                        'is_success' => ['required', 'boolean'],
                        'amount' => ['required', 'numeric'],
                        'additional_info' => ['sometimes', 'string', 'max:255'],
                    ];
                }
            default:
                return [];
        }
    }
}
