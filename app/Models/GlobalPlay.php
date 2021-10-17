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
        $data = DB::table('global_plays')
            ->whereDate('created_at', '>=', '2021-10-16')
            ->whereTime('created_at', '>', '16:00:00')
            ->get();
        return $data;
    }

    public function getYesterdayGlobalActivityBy3Hours()
    {
        $tz = new DateTimeZone('Europe/Madrid');
        $date = new DateTime("NOW", $tz);
        $oneDayInterval = new DateInterval('P1D');
        $date->sub($oneDayInterval);

        $yesterday = $date->format("Y-m-d");

        $data = [];

        for ($i = 0; $i < 8; $i++) {
            $strI = strval($i * 3);
            if ($i * 3 < 10) {
                $start = "0" . $strI . ":00:00";
            } else {
                $start = $strI . ":00:00";
            }

            $j = ($i * 3) + 2;
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

            // echo $start, " ", $end, "\n";
            array_push($data, count($interval));
        }

        return json_encode($data);
    }

    use HasFactory;
}
