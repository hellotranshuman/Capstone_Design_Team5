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
        $reviewContents =$request->get('reviewContents');
        return response()->json([
            'content' => $reviewContents,
        ]);
    }
}
