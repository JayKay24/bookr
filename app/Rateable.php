<?php

namespace App;

/**
 * Trait to enable polymorphic ratings on a model.
 *
 * @package App
 */
trait Rateable
{
    /**
     * @return mixed
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }
}