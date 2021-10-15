<?php

namespace App\Http\Controllers;

use App\Models\GlobalPlay;
use Illuminate\Http\Request;

class GlobalPlayController extends Controller
{
    //
    public function getGobalPlays()
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
}
