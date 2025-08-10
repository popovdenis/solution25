<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $userId = auth('api')->id();

        return [
            'title' => [
                'required','string','max:255',
                Rule::unique('books','title')->where(fn($q) =>
                $q->where('user_id',$userId)
                    ->where('author',$this->input('author'))
                    ->where('publication_year',$this->input('publication_year'))
                ),
            ],
            'author' => ['required','string','max:255'],
            'publication_year' => ['required','integer','min:1'],
            'cover' => ['nullable','file','image','mimes:jpeg,png,webp','max:2048'],
        ];
    }
}
