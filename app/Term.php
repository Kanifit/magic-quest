<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'term',
        'description'
    ];

    public function books()
    {
    	return $this->belongsToMany('App\Book');
    }
}
