<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookFilter
{
    protected $request;
    protected $query;

    public function __construct(Request $request, Builder $query)
    {
        $this->request = $request;
        $this->query = $query;
    }

    public function apply(): Builder
    {
        if ($title = $this->request->query('title')) {
            $this->query->where('title', 'like', "%{$title}%");
        }

        if ($authorId = $this->request->query('author_id')) {
            $this->query->where('author_id', $authorId);
        }

        if ($categoryId = $this->request->query('category_id')) {
            $this->query->where('category_id', $categoryId);
        }

        return $this->query;
    }
}
