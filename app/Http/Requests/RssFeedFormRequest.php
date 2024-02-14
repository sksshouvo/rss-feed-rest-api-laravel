<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RssFeedFormRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function store() : array {
        return [
            "title" => ["required", "string"],
            "link" => [
                "required",
                "url:http,https",
                Rule::unique('rss_feeds')->where(function ($query) {
                    return $query->where('created_by', auth()->id());
                })
            ],
            "published_at" => ["required", "date_format:Y-m-d H:i:s"]
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function rules(): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
