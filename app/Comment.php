<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comments', 'post_id'];

    public function posts()
    {
        return $this->belongsTo('App\Posts');
    }
}
