<?php

namespace App\Http\Controllers;

use App\Models\GlobalPlay;
use Illuminate\Http\Request;

class GlobalPlayController extends Controller
{
    //
    public function getAllGlobalPlays()
    {
        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->get();
        $response =
            [
                "status" => "success",
                "gobalPlays" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getLastGlobalActivity()
    {
        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getLastGlobalActivity();
        $response =
            [
                "status" => "success",
                "lastActivity" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function storeGlobalPlay(Request $request)
    {
        $gbPlay = new GlobalPlay;
        $gbPlay->track_id = $request->trackId;
        $gbPlay->track_owner_id = $request->trackOwnerId;
        $gbPlay->track_player_id = $request->trackPlayerId;
        $gbPlay->save();

        return response()->json([
            "message" => "Play record created"
        ], 201);
    }
}
