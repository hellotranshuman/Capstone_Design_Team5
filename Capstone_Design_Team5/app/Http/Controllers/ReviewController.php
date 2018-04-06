<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

class ReviewController extends Controller
{
    public function showReview() {
        return view('user.review');
    }

    public function showReviewForm() {
        return view('user.writeReview');
    }

    public function createReview(Request $request) {

        $tags = $request->get('reviewContents');

        $tagCount = count($tags);

        return response()->json([
            'content' => $tags,
        ]);

        /*
        // Current Save Shop Image Route
        $path = storage_path() . '/app/public/img/review';

        if($request->file('image1')) {
            $request->image1->store('public/review');

            return response()->json([
                'content' =>'ddddddddddd',
            ]);
        }
        else {
            return response()->json([
                'content' => $request->get('image1'),
            ]);
        } */


    }
}
