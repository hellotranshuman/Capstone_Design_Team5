<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Review;


class ReviewController extends Controller
{
    public function showReviewForm() {
        return view('user.review');
    }

    public function getReviewData(Request $request) {

        $review = Review::join('users', 'users.id', '=', 'review.writer')
                    ->select('review.*', 'users.name', 'users.country')
                    ->where('shop_id', $request->get('shop_id'))
                    ->orderByRaw('reg_date DESC')
                    ->get()
                    ->toArray();

        $totalRating = Review::select(DB::raw('AVG(rating) as totalRating'))
                        ->where('shop_id', $request->get('shop_id'))
                        ->orderByRaw('reg_date DESC')
                        ->get()
                        ->toArray();

        $reviewImage = Review::join('review_image', 'review_image.review_id', '=', 'review.id')
                        ->select('review_image.filename')
                        ->orderByRaw('review.reg_date DESC')
                        ->where('shop_id', $request->get('shop_id'))
                        ->get()
                        ->toArray();

        $reviewData = array_merge($totalRating, $review, $reviewImage);

        return response()->json([
            'test' => $request->get('shop_id'),
            'review' => $reviewData,
            'path'   => 'images/review/',
        ]);
    }

    public function showWriteReviewForm() {
        return view('user.writeReview');
    }

    public function createReview(Request $request) {
        // 현재 시간 불러오기
        $currentDate = date("Y-m-d H:i:s");

        // create Review column in Review Table
        \App\Review::create([
            'shop_id' => $request->get('shop_id'),
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

        // <-- current Review Id 가져오기
        $review =  DB::table('review')
                    ->select('id')
                    ->where('writer', auth()->user()->id)
                    ->orderByRaw('id DESC')
                    ->first();

        $reviewId = $review->id;

        // <-- hash Tag column create in HashTag Table
        $tags = implode(',' , $request->get('HASHTAG'));
        $hashTag = str_replace('#', '', $tags);
        $hashTags = explode(',', $hashTag);

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
        $fileIndex = 1;

        // <-- Image Save
        if($imgNum != 0) {
            for( $num = 1 ; $num <= 3 ; $num++ )
            {

                // 해당 번호의 Image 있는지 확인
                $fileName = 'imgFile' . $num;

                if ($request->file($fileName))
                {
                    // image file Save
                    $file = $request->file($fileName);

                    $imgName = $reviewId . '_reviewImg_' . $fileIndex . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('review', $imgName);

                    $fileIndex++;

                    // create reviewImage column in Review_Image Table
                    \App\Review_Image::create ([
                        'review_id' => $reviewId,
                        'filename' => $imgName,
                    ]);

                }

            }

        }


        $link = route('review.showReviewForm' , ['shop_id' => $request->get('shop_id')]);

        return response()->json([
            'content' => '리뷰 작성이 완료되었습니다.',
            'link'    => $link,
        ]);

    }
}
