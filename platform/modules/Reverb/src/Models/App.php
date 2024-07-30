<?php

namespace SokeioModule\Reverb\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table = 'apps';
    protected $fillable = [
        "key", "secret",  "allowed_origins", "ping_interval",
        "max_message_size", "options"
    ];
    protected $guarded = [];
    protected $casts = [
        "options" => "json",
        "allowed_origins" => "json",
        "ping_interval" => "integer",
        "max_message_size" => "integer"
    ];
}
