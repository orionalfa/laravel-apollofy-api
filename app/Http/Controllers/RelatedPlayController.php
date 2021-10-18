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
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function storeRelatedPlay(Request $request)
    {
        $relatedPlay = new RelatedPlay;
        $relatedPlay->prev_track_id = $request->prevTrackId;
        $relatedPlay->next_track_id = $request->nextTrackId;
        $relatedPlay->user_player_id = $request->userPlayerId;
        $relatedPlay->save();

        return response()->json([
            "message" => "Related play record stored"
        ], 201);
    }

    public function getMostRelatedTracks()
    {
        $relatedPlay = new RelatedPlay();
        $data = $relatedPlay->getMostRelatedTracks();
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getMostRelatedTracksById(Request $request)
    {
        $track_id = $request->route('track_id');

        $relatedPlay = new RelatedPlay();
        $data = $relatedPlay->getMostRelatedTracksById($track_id);
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }
}
