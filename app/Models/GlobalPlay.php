<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GlobalPlay extends Model
{
    public function get()
    {

        $data = DB::table('global_plays')->get();

        return $data;
    }

    use HasFactory;
}
