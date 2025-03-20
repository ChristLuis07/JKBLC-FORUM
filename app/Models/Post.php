<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $guarded = ["id"];

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    function comments(): HasMany
    {
        return $this->hasMany(Comments::class);
    }
}
