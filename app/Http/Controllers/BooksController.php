<?php

namespace App\Http\Controllers;
/*
 * Class BooksController
 * @package App\Http\Controllers
 */
use App\Book;

class BooksController
{
    /**
     * GET /books
     * @return array
     */
    public function index()
    {
        return Book::all();
    }
}