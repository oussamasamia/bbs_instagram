<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'image_id',
        'media_type',
        'media_url',
        'permalink',
        'post_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
