<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title','author','publication_year','cover_path','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // users that added the book in their library
    public function users()
    {
        return $this->belongsToMany(User::class, 'book_user')->withTimestamps();
    }

    // save route-binding: restrict the access to the owner books
    public function resolveRouteBinding($value, $field = null)
    {
        $model = static::query()
            ->where($field ?? $this->getRouteKeyName(), $value)
            ->where('user_id', auth('api')->id())
            ->first();

        if (! $model) abort(404);

        return $model;
    }
}
