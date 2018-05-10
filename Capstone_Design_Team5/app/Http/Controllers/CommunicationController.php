<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Communication;
use App\CommuBookmark;

class CommunicationController extends Controller
{

    // <-- get Emoticon Info in Communication Table
    public function getEmoticonList() {

        if(auth()->check()) {
            $userBookmarkList = CommuBookmark::
                                join('communication', 'commu_bookmark.emoticon_num', '=', 'communication.id')
                                ->select('communication.*')
                                ->where('user_num', auth()->user()->id)
                                ->get()
                                ->toArray();
        }
        else
            $userBookmarkList = '';


        $emoticonList = Communication::all()
                        ->toArray();


        return response()->json([
           'userBookmark' => $userBookmarkList,
           'emoticonList' => $emoticonList,
        ]);

    }

    public function addUserBookmark(Request $request) {
        if(!auth()->check())
             return response()->json([
                 'msg' => '로그인 후 즐겨찾기가 가능합니다',
             ]);
        else {
            if($request->get('bookmark_status')) {
                CommuBookmark::create([
                    'user_num'     => auth()->user()->id,
                    'emoticon_num' => $request->get('emoticon_num')
                ]);

                $msg = '즐겨찾기가 완료되었습니다';
            }
            else {
                CommuBookmark::where('user_num', auth()->user()->id)
                                ->where('emoticon_num', $request->get('emoticon_num'))
                                ->delete();

                $msg = '즐겨찾기가 삭제되었습니다';
            }

            return response()->json([
                'msg' => $msg,
            ]);
        }

    }
}
