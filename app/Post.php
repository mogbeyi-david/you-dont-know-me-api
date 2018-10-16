<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['post_type_id', 'post', 'caption'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
