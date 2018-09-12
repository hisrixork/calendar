<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worktime extends Model
{
    protected $fillable = [
        'start', 'stop'
    ];
}
