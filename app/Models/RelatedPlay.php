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

    use HasFactory;
}
