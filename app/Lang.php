<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
	protected $fillable = [
		'code',
        'title'
    ];

    public function books()
    {
    	return $this->hasMany('App\Books', 'lang_id');
    }

    public function srcLangBooks()
    {
    	return $this->hasMany('App\Books', 'src_lang_id');
    }
}
