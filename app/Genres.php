<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
    	'code',
        'title',
    ];

    public function books()
    {
    	return $this->belongsToMany('App\Book');
    }
}
