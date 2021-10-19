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

    public function getTotalGlobalActivity()
    {
        $data = DB::table('global_plays')->count();
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
            // $slot = $yesterday . " " . $start . " - " . $yesterday . " " . $end;

            $intervalActivity = [
                "start" => $yesterday . " " . $start,
                "end" => $yesterday . " " . $end,
                "playsCount" => count($interval)

            ];
            array_push($data, $intervalActivity);
            // array_push($data, count($interval));
        }

        return json_encode($data);
    }


    public function getYesterdayActivityByHours($owner_id)
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
                ->where('track_owner_id', '=', $owner_id)
                ->get();

            $intervalActivity = [
                "start" => $yesterday . " " . $start,
                "end" => $yesterday . " " . $end,
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
        // ALERT : 3h interval because post timestamp has -2h diff with real time
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

    public function getLast24HoursPlaysByOwner($owner_id)
    {
        // echo 'getLast24HoursPlaysByOwner', "\n";

        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        $today = $date->format("Y-m-d");

        // ALERT : 26h interval because post timestamp has -2h diff with real time
        $oneHourInterval = new DateInterval('PT26H');
        $date->sub($oneHourInterval);
        $yesterday = $date->format("Y-m-d");
        $twentyFourHoursAgoTime = $date->format("h:i:s");

        // echo $today, "\n";
        // echo $yesterday, "\n";
        // echo $twentyFourHoursAgoTime, "\n";

        $dataYesterday = DB::table('global_plays')
            ->where('track_owner_id', '=', $owner_id)
            ->whereDate('created_at', '=', $yesterday)
            ->whereTime('created_at', '>', $twentyFourHoursAgoTime)
            ->get();

        $dataToday = DB::table('global_plays')
            ->where('track_owner_id', '=', $owner_id)
            ->whereDate('created_at', '=', $today)
            ->whereTime('created_at', '<', $twentyFourHoursAgoTime)
            ->get();


        return count($dataToday) + count($dataYesterday);
    }

    public function getLast24HMostPlayedTracksByOwner($owner_id)
    {
        // echo 'getLast24HMostPlayedTracksByOwner', "\n";

        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        // ALERT : 26h interval because post timestamp has -2h diff with real time
        $oneHourInterval = new DateInterval('PT26H');
        $date->sub($oneHourInterval);

        $start = $date->format("Y-m-d H:i:s");
        // echo $start, "\n";

        $data = DB::table('global_plays')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('track_owner_id', '=', $owner_id)
            ->where('created_at', '>', $start)
            ->groupBy('track_id')
            ->orderByRaw('total DESC')
            ->get();

        // return json_encode($data);
        return $data;
    }

    public function getLast24HMostPlayedGlobal()
    {
        // echo 'getLast24HMostPlayedTracksByOwner', "\n";

        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        // ALERT : 26h interval because post timestamp has -2h diff with real time
        $oneHourInterval = new DateInterval('PT26H');
        $date->sub($oneHourInterval);

        $start = $date->format("Y-m-d H:i:s");
        // echo $start, "\n";

        $data = DB::table('global_plays')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('created_at', '>', $start)
            ->groupBy('track_id')
            ->orderByRaw('total DESC')
            ->get();

        // return json_encode($data);
        return $data;
    }


    public function getLastWeekMostPlayedTracksByOwner($owner_id)
    {
        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        $oneHourInterval = new DateInterval('P7D');
        $date->sub($oneHourInterval);

        $start = $date->format("Y-m-d H:i:s");
        // echo $start, "\n";

        $data = DB::table('global_plays')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('track_owner_id', '=', $owner_id)
            ->where('created_at', '>', $start)
            ->groupBy('track_id')
            ->orderByRaw('total DESC')
            ->get();

        // return json_encode($data);
        return $data;
    }

    public function getLastWeekMostPlayedGlobal()
    {
        // echo 'getLast24HMostPlayedTracksByOwner', "\n";

        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        $oneHourInterval = new DateInterval('P7D');
        $date->sub($oneHourInterval);

        $start = $date->format("Y-m-d H:i:s");
        // echo $start, "\n";

        $data = DB::table('global_plays')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('created_at', '>', $start)
            ->groupBy('track_id')
            ->orderByRaw('total DESC')
            ->get();

        // return json_encode($data);
        return $data;
    }

    public function getLastWeekMostPlayedTracksByUser($user_id)
    {
        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        $oneHourInterval = new DateInterval('P7D');
        $date->sub($oneHourInterval);

        $start = $date->format("Y-m-d H:i:s");
        // echo $start, "\n";

        $data = DB::table('global_plays')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('track_player_id', '=', $user_id)
            ->where('created_at', '>', $start)
            ->groupBy('track_id')
            ->orderByRaw('total DESC')
            ->get();

        // return json_encode($data);
        return $data;
    }

    public function getWeekTop5Random()
    {
        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        $oneHourInterval = new DateInterval('P7D');
        $date->sub($oneHourInterval);

        $start = $date->format("Y-m-d H:i:s");

        $tracksList = DB::table('global_plays')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('created_at', '>', $start)
            ->groupBy('track_id')
            ->orderByRaw('total DESC')
            ->get();

        $size = count($tracksList);
        if ($size >= 5) {
            $top5 = array_slice(json_decode($tracksList), 0, 5);
            shuffle($top5);
            $data = $top5;
        } else {
            $placeholder = [
                'track_id' => '615c32898ac7d2a27005fd04',
                'total' => 1,
            ];
            $data = [
                $placeholder,
                $placeholder,
                $placeholder,
                $placeholder,
                $placeholder
            ];
        }

        return json_encode($data);
        // return $data;
    }

    public function getMonthTop5Random()
    {
        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        $oneHourInterval = new DateInterval('P30D');
        $date->sub($oneHourInterval);

        $start = $date->format("Y-m-d H:i:s");

        $tracksList = DB::table('global_plays')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('created_at', '>', $start)
            ->groupBy('track_id')
            ->orderByRaw('total DESC')
            ->get();

        $size = count($tracksList);
        if ($size >= 5) {
            $top5 = array_slice(json_decode($tracksList), 0, 5);
            shuffle($top5);
            $data = $top5;
        } else {
            $placeholder = [
                'track_id' => '615c32898ac7d2a27005fd04',
                'total' => 1,
            ];
            $data = [
                $placeholder,
                $placeholder,
                $placeholder,
                $placeholder,
                $placeholder
            ];
        }

        return json_encode($data);
        // return $data;
    }



    use HasFactory;
}
