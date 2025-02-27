<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AutoPost extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function post(): MorphTo
    {
        return $this->morphTo();
    }
}
