<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Communication;
use App\CommuBookmark;

class CommunicationController extends Controller
{

    // <-- get Emoticon Info in Communication Table
    public function getEmoticonList() {

        $userBookmarkList = CommuBookmark::
                            join('communication', 'commu_bookmark.emoticon_num', '=', 'communication.id')
                            ->select('communication.*')
                            ->where('user_num', auth()->user()->id)
                            ->get()
                            ->toArray();

        $emoticonList = Communication::all()
                        ->toArray();


        return response()->json([
           'userBookmark' => $userBookmarkList,
           'emoticonList' => $emoticonList,
        ]);

    }

    public function addUserBookmark() {

    }
}
