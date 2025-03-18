<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comments extends Model
{
    protected $guarded = ["id"];

    function users() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    function psost() : BelongsTo {
        return $this->belongsTo(Post::class);
    }

}
