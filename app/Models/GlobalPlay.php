<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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


    use HasFactory;
}
