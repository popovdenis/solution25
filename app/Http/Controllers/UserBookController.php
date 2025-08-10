<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachBookToUserRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class UserBookController extends Controller
{
    public function index(User $user, Request $r)
    {
        $this->authorizeSelf($user);
        $q = $user->libraryBooks()->getQuery();

        if ($term = trim((string)$r->query('q'))) {
            $q->where(function ($qq) use ($term) {
                $qq->where('title', 'like', "%{$term}%")->orWhere('author', 'like', "%{$term}%");
            });
        }

        $sort = collect(explode(',', (string)$r->query('sort', 'title')))->filter()->map(fn($f) => [
            ltrim($f, '-'),
            str_starts_with($f, '-') ? 'desc' : 'asc'
        ]);
        foreach ($sort as [$field, $dir]) {
            if (in_array($field, [
                'title',
                'author',
                'publication_year',
                'created_at'
            ])) {
                $q->orderBy($field, $dir);
            }
        }

        $per = max(1, min((int)$r->query('per_page', 10), 100));

        return BookResource::collection($q->paginate($per));
    }

    public function available(User $user, Request $r)
    {
        $this->authorizeSelf($user);
        $linkedIds = $user->libraryBooks()->pluck('books.id');

        $q = Book::query()->whereNotIn('id', $linkedIds);

        if ($term = trim((string)$r->query('q'))) {
            $q->where(function ($qq) use ($term) {
                $qq->where('title', 'like', "%{$term}%")->orWhere('author', 'like', "%{$term}%");
            });
        }

        $sort = collect(explode(',', (string)$r->query('sort', 'title')))->filter()->map(fn($f) => [
            ltrim($f, '-'),
            str_starts_with($f, '-') ? 'desc' : 'asc'
        ]);
        foreach ($sort as [$field, $dir]) {
            if (in_array($field, [
                'title',
                'author',
                'publication_year',
                'created_at'
            ])) {
                $q->orderBy($field, $dir);
            }
        }

        $per = max(1, min((int)$r->query('per_page', 10), 100));

        return BookResource::collection($q->paginate($per));
    }

    public function store(User $user, AttachBookToUserRequest $r)
    {
        $this->authorizeSelf($user);
        $bookId = (int) $r->validated()['book_id'];
        $user->libraryBooks()->attach($bookId);
        $book = Book::findOrFail($bookId);

        return (new BookResource($book))->response()->setStatusCode(201);
    }

    public function destroy(User $user, Book $book)
    {
        $this->authorizeSelf($user);
        $user->libraryBooks()->detach($book->id);

        return response()->json([], 204);
    }

    protected function authorizeSelf(User $user): void
    {
        abort_unless(auth('api')->id() === $user->id, 403, 'Forbidden');
    }

    public function indexMe(Request $r)
    {
        $user = $r->user();

        return $this->index($user, $r);
    }

    public function availableMe(Request $r)
    {
        $user = $r->user();

        return $this->available($user, $r);
    }

    public function storeMe(AttachBookToUserRequest $r)
    {
        $user = $r->user();

        return $this->store($user, $r);
    }

    public function destroyMe(Request $r, Book $book)
    {
        $user = $r->user();

        return $this->destroy($user, $book);
    }
}
