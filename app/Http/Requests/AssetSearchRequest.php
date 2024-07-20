<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetSearchRequest extends FormRequest
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
            'search-date' => 'required|date',
            'debut-search-flg' => 'string',
            'first-day-of-month' => 'date',
        ];
    }

    public function messages()
    {
        return [
            'search-date.required' => '日付を入力してください。',
            'search-date.date' => '検索日付は有効な日付形式で入力してください。',
            'debut-search-flg.string' => '負債検索フラグは文字列でなければなりません。',
            'first-day-of-month.date' => '月初日は有効な日付形式で入力してください。',
        ];
    }
}
