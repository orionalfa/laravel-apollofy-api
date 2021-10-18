<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;
use DateInterval;

class GlobalPlay extends Model
{
    protected $fillable  = ['track_id', 'track_owner_id', 'track_player_id'];

    public function get()
    {
        $data = DB::table('global_plays')->get();
        return $data;
    }

    public function getLastGlobalActivity()
    {
        // TODO
        $data = DB::table('global_plays')
            ->whereDate('created_at', '>=', '2021-10-16')
            ->whereTime('created_at', '>', '16:00:00')
            ->get();
        return $data;
    }

    public function getYesterdayGlobalActivityByHours()
    {
        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        $oneDayInterval = new DateInterval('P1D');
        $date->sub($oneDayInterval);

        $yesterday = $date->format("Y-m-d");

        $data = [];

        for ($i = 0; $i < 24; $i++) {
            $strI = strval($i);
            if ($i < 10) {
                $start = "0" . $strI . ":00:00";
            } else {
                $start = $strI . ":00:00";
            }

            $j = $i;
            $strJ = strval($j);
            if ($j < 10) {
                $end = "0" . $strJ . ":59:59";
            } else {
                $end = $strJ . ":59:59";
            }
            $interval = DB::table('global_plays')
                ->whereDate('created_at', '=', $yesterday)
                ->whereTime('created_at', '>=', $start)
                ->whereTime('created_at', '<=', $end)
                ->get();

            // echo $start, "-", $end, "\n";
            $slot = $yesterday . " " . $start . " - " . $yesterday . " " . $end;

            $intervalActivity = [
                "interval" => $slot,
                "playsCount" => count($interval)

            ];
            array_push($data, $intervalActivity);
            // array_push($data, count($interval));
        }

        return json_encode($data);
    }

    public function getTotalPlaysByOwner($owner_id)
    {
        // echo $owner_id, "\n";
        // $owner_id = "61547811a05e38da71626988";

        $data = DB::table('global_plays')
            ->where('track_owner_id', '=', $owner_id)
            ->get();
        return count($data);
    }

    public function getLastHourPlaysByOwner($owner_id)
    {
        // echo 'getLastHourPlaysByOwner', "\n";

        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        // ALERT : 3h interval because post timestamp has 2h gap with real time
        $oneHourInterval = new DateInterval('PT3H');
        $date->sub($oneHourInterval);

        $today = $date->format("Y-m-d");
        $oneHourAgo = $date->format("h:i:s");

        // echo $oneHourAgo, "\n";

        $data = DB::table('global_plays')
            ->where('track_owner_id', '=', $owner_id)
            ->whereDate('created_at', '=', $today)
            ->whereTime('created_at', '>', $oneHourAgo)
            ->get();
        return count($data);
    }


    use HasFactory;
}
