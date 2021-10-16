<?php

namespace App\Http\Controllers;

use App\Models\RelatedPlay;
use Illuminate\Http\Request;

class RelatedPlayController extends Controller
{
    public function getAllRelatedPlays()
    {
        $relatedPlay = new RelatedPlay();
        $data = $relatedPlay->get();
        $response =
            [
                "status" => "success",
                "relatedPlays" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function storeRelatedPlay(Request $request)
    {
        $relatedPlay = new RelatedPlay;
        $relatedPlay->prev_track_id = $request->prevTrackId;
        $relatedPlay->next_track_id = $request->nextTrackId;
        $relatedPlay->save();

        return response()->json([
            "message" => "Related play record stored"
        ], 201);
    }
}
