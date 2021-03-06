<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use Rateable;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'author_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bundles()
    {
        return $this->belongsToMany(\App\Bundle::class);
    }
}