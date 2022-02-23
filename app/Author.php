<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
    	'first_name',
        'last_name',
        'middle_name',
        'nickname',
        'homepage',
        'email',
    ];

    //Список книг автора
    public function books()
    {
    	return $this->belongsToMany('App\Book');
    }
}
