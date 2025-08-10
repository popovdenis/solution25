<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $r)
    {
        // owner books only
        $query = Book::query()->where('user_id', auth('api')->id());

        // search (optional)
        if ($term = trim((string)$r->query('q'))) {
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")->orWhere('author', 'like', "%{$term}%");
            });
        }

        // sort
        $sort = collect(explode(',', (string) $r->query('sort', 'id')))->filter()->map(fn($f) => [
            ltrim($f, '-'),
            str_starts_with($f, '-') ? 'desc' : 'asc'
        ]);
        foreach ($sort as [$field, $dir]) {
            if (in_array($field, [
                'id',
                'title',
                'author',
                'publication_year',
                'created_at'
            ])) {
                $query->orderBy($field, $dir);
            }
        }

        $per = max(1, min((int)$r->query('per_page', 10), 100));

        return BookResource::collection($query->paginate($per));
    }

    public function store(StoreBookRequest $r)
    {
        $data = $r->validated();
        if ($r->hasFile('cover')) {
            $data['cover_path'] = $r->file('cover')->store('covers', 'public');
        }
        $data['user_id'] = auth('api')->id();
        $book            = Book::create($data);

        return (new BookResource($book))->response()->setStatusCode(201);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(UpdateBookRequest $r, Book $book)
    {
        $data = $r->validated();
        if ($r->hasFile('cover')) {
            $data['cover_path'] = $r->file('cover')->store('covers', 'public');
        }
        $book->update($data);
        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([], 204);
    }
}
