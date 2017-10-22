<?php

namespace App\Transformer;

use App\Author;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'books'
    ];

    /**
     * @param Author $author
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBooks(Author $author)
    {
        return $this->collection($author->books, new BookTransformer());
    }

    /**
     * Transform an author model
     *
     * @param Author $author
     * @return array
     */
    public function transform(Author $author)
    {
        return [
            'id' => $author->id,
            'name' => $author->name,
            'gender' => $author->gender,
            'biography' => $author->biography,
            'created' => $author->created_at->toIso8601String(),
            'updated' => $author->updated_at->toIso8601String(),
        ];
    }
}