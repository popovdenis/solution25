<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $userId = auth('api')->id();
        $book  = $this->route('book');

        return [
            'title' => [
                'sometimes','string','max:255',
                Rule::unique('books','title')
                    ->ignore($book?->id)
                    ->where(fn($q) =>
                    $q->where('user_id',$userId)
                        ->where('author',$this->input('author', $book?->author))
                        ->where('publication_year',$this->input('publication_year', $book?->publication_year))
                    ),
            ],
            'author' => ['sometimes','string','max:255'],
            'publication_year' => ['sometimes','integer','min:1'],
            'cover' => ['nullable','file','image','mimes:jpeg,png,webp','max:2048'],
        ];
    }
}
