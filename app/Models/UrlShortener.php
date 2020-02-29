<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlShortener extends Model
{
    public $fillable = [
        'code',
        'url',
        'click_count'
    ];
}
