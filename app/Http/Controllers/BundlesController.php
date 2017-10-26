<?php

namespace App\Http\Controllers;

use App\Bundle;
use App\Transformer\BundleTransformer;

class BundlesController extends Controller
{
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id)
    {
        $bundle = Bundle::findOrFail($id);
        $data = $this->item($bundle, new BundleTransformer());

        return response()->json($data);
    }

    /**
     * @param $bundleId
     * @param $bookId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addBook($bundleId, $bookId)
    {
        $bundle = \App\Bundle::findOrFail($bundleId);
        $book = \App\Book::findOrFail($bookId);

        $bundle->books()->attach($book);
        $data = $this->item($bundle, new BundleTransformer());

        return response()->json($data);
    }

    /**
     * @param $bundleId
     * @param $bookId
     * @return \Laravel\Lumen\Http\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function removeBook($bundleId, $bookId)
    {
        $bundle = \App\Bundle::findOrFail($bundleId);
        $book = \App\Book::findOrFail($bookId);

        $bundle->books()->detach($book);

        return response(null, 204);
    }
}