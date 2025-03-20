<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comments extends Model
{
    protected $guarded = ["id"];

    protected $hidden = ["user_id", "post_id"];

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
