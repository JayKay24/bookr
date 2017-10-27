<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use App\Transformer\RatingTransformer;

/**
 * Manage an Author's Ratings
 *
 * Class AuthorsRatingsController
 * @package App\Http\Controllers
 */
class AuthorsRatingsController extends Controller
{
    /**
     * @param Request $request
     * @param $authorId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request, $authorId)
    {
        $author = Author::findOrFail($authorId);

        $rating = $author->ratings()->create(['value' => $request->get('value')]);
        $data = $this->item($rating, new RatingTransformer());

        return response()->json($data, 201);
    }

    /**
     * @param $authorId
     * @param $ratingId
     * @return \Laravel\Lumen\Http\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($authorId, $ratingId)
    {
        $author = Author::findOrFail($authorId);
        $author
            ->ratings()
            ->findOrFail($ratingId)
            ->delete();

        return response(null, 204);
    }
}