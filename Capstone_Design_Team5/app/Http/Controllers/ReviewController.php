<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;


class ReviewController extends Controller
{
    public function showReview() {

        $review =  DB::table('review')
            ->select('id', 'content', 'reg_date','writer', 'img_num', 'rating',
                     'taste', 'service', 'mood', 'price')
            ->where('shop_id', 13)
            ->orderByRaw('reg_date DESC')
            ->get();
        
        return view('user.review', ['review' => $review]);
    }

    public function showReviewForm() {
        return view('user.writeReview');
    }

    public function createReview(Request $request) {

        $currentDate = date("Y-m-d H:i:s");

        // create Review column in Review Table
        \App\Review::create([
            'shop_id' => 13,
            'content'=> $request->get('CONTENT'),
            'reg_date' => $currentDate,
            'writer' => auth()->user()->id,
            'rating' => $request->get('RATING'),
            'taste' => $request->get('TASTE'),
            'service' => $request->get('SERVICE'),
            'mood' => $request->get('MOOD'),
            'price' => $request->get('PRICE'),
            'img_num' => $request->get('imgNum'),
        ]);

        $review =  DB::table('review')
                    ->select('id')
                    ->where('writer', auth()->user()->id)
                    ->orderByRaw('id DESC')
                    ->first();

        $reviewId = $review->id;

        $hashtag = str_replace('#', '',$request->get('HASHTAG'));
        $hashTags = explode(',', $hashtag);

        for( $num = 0 ; $num < count($hashTags) ; $num++)
        {
            \App\Hashtag::create([
                'tag' => $hashTags[$num],
                'review_id' => $reviewId
            ]);
        }

        /*
         * 1. 리뷰 이미지 갯수 확인
         * 2. 리뷰 이미지 있으면 갯수 만큼 저장후 테이블에도 저장 
         * */

        $imgNum = $request->get('imgNum');

        if($imgNum != 0) {
            for( $num = 1 ; $num <= $imgNum ; $num++ )
            {

                $fileName = 'imgFile' . $num;
                $file = $request->file($fileName);

                $imgName = $reviewId . '_reviewImg_' . $num . '.' . $file->getClientOriginalExtension();
                $file->storeAs('review', $imgName);

                \App\Review_Image::create ([
                   'review_id' => $reviewId,
                   'filename' => $imgName,
                ]);

            }

            return response()->json([
                'content' => $request->get('HASHTAG'),
            ]);

        }

    }
}
