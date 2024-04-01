<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:20',
            'amount' => 'required|min:-9999999999999|max:9999999999999',
            'registration_date' => 'required|before_or_equal:today',
            'category_id' => 'required',
            'asset-type-flg' => 'required'
        ];
    }
}
