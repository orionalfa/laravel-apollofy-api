<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RelatedPlay extends Model
{

    protected $fillable  = ['prev_track_id', 'next_track_id', 'user_player_id'];

    public function get()
    {
        $data = DB::table('related_plays')->get();
        return $data;
    }

    public function getMostRelatedTracks()
    {
        // echo $start, "\n";
        $data = DB::table('related_plays')
            ->select('prev_track_id', 'next_track_id', DB::raw('count(*) as total'))
            ->groupBy('prev_track_id')
            ->groupBy('next_track_id')
            ->orderByRaw('total DESC')
            ->get();

        // return json_encode($data);
        return $data;
    }

    public function getMostRelatedTracksById($track_id)
    {

        $data = DB::table('related_plays')
            ->select('next_track_id', DB::raw('count(*) as total'))
            ->where('prev_track_id', '=', $track_id)
            ->groupBy('next_track_id')
            ->orderByRaw('total DESC')
            ->get();

        // return json_encode($data);
        return $data;
    }

    public function getRandomRelatedTrackById($track_id)
    {
        $relatedPlay = new RelatedPlay();
        $relatedTracks = $relatedPlay->getMostRelatedTracksById($track_id);
        $size = count($relatedTracks);
        if ($size > 0) {
            if ($size > 5) {
                $size = 5;
            }
            $randomIndex = random_int(0, $size - 1);
            // $randomIndex = time() % $size;
            // echo $randomIndex, "\n";

            $data = $relatedTracks[$randomIndex];
        } else {
            $data = [];
        }
        // return json_encode($data);
        return json_encode($data);
    }





    use HasFactory;
}
