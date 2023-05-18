<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'post_id',
        'media_type',
        'media_url',
        'permalink',
        'timestamp',
        'username',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
