<?php

namespace App\Http\Controllers;

use App\Models\GlobalPlay;
use Illuminate\Http\Request;

class GlobalPlayController extends Controller
{
    public function storeGlobalPlay(Request $request)
    {
        $gbPlay = new GlobalPlay;
        $gbPlay->track_id = $request->trackId;
        $gbPlay->track_owner_id = $request->trackOwnerId;
        $gbPlay->track_player_id = $request->trackPlayerId;
        $gbPlay->save();

        // ALERT : post timestamp has 2h gap with real time

        return response()->json([
            "message" => "Play record created"
        ], 201);
    }

    public function getAllGlobalPlays()
    {
        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->get();
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

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
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getYesterdayGlobalActivityByHours()
    {
        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getYesterdayGlobalActivityByHours();
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getYesterdayActivityByHours(Request $request)
    {
        $owner_id = $request->route('owner_id');

        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getYesterdayActivityByHours($owner_id);
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }


    public function getTotalPlaysByOwner(Request $request)
    {
        $owner_id = $request->route('owner_id');

        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getTotalPlaysByOwner($owner_id);
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getLastHourPlaysByOwner(Request $request)
    {
        $owner_id = $request->route('owner_id');

        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getLastHourPlaysByOwner($owner_id);
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getLast24HoursPlaysByOwner(Request $request)
    {
        $owner_id = $request->route('owner_id');

        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getLast24HoursPlaysByOwner($owner_id);
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getLast24HMostPlayedTracksByOwner(Request $request)
    {
        $owner_id = $request->route('owner_id');

        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getLast24HMostPlayedTracksByOwner($owner_id);
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getLast24HMostPlayedGlobal()
    {

        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getLast24HMostPlayedGlobal();
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }


    public function getLastWeekMostPlayedTracksByOwner(Request $request)
    {
        $owner_id = $request->route('owner_id');

        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getLastWeekMostPlayedTracksByOwner($owner_id);
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getLastWeekMostPlayedGlobal()
    {
        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getLastWeekMostPlayedGlobal();
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }

    public function getLastWeekMostPlayedTracksByUser(Request $request)
    {
        $user_id = $request->route('user_id');

        $gobalPlay = new GlobalPlay();
        $data = $gobalPlay->getLastWeekMostPlayedTracksByUser($user_id);
        $response =
            [
                "status" => "success",
                "data" => json_decode($data, true)

            ];

        return response()->json($response);
    }
}
