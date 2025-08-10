<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachBookToUserRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $userParam = $this->route('user');
        $userId = $userParam?->id ?? auth('api')->id();

        return [
            'book_id' => [
                'required','integer','exists:books,id',
                Rule::unique('book_user','book_id')->where(fn($q) => $q->where('user_id',$userId)),
            ],
        ];
    }

    public function messages(): array
    {
        return ['book_id.unique' => 'The book has already been bound to that user.'];
    }
}
