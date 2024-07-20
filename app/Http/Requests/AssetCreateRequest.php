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
            'name' => 'required|string|max:30',
            'amount' => 'required|string|min:-9999999999999|max:9999999999999',
            'registration_date' => 'required|string|before_or_equal:today',
            'genre_id' => 'required|string',
            'category_id' => 'required|string',
            'asset_type_flg' => 'required|string'
        ];
    }
}
