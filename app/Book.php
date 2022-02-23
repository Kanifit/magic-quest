<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
    	'book_title',
	    'version',
	    'fb2_id',
	    'text_index',
	    'annotation',
	    'book_keywords',
	    'year_of_publishing',
	    'city',
	    'isbn',
	    'date_of_writing',
	    'bibliographic_list',
	    'user_id',
	    'lang_id',
	    'publisher_id',
	    'cover_file_id',
	    'book_file_id',
	    'src_lang_id',
	    'available',
    ];

    //Пользователь загрузившиё/создавшиё книгу
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    //Издатель
    public function publisher()
    {
    	return $this->belongsTo('App\Publisher');
    }

    //Текущий язык книги
    public function lang()
    {
    	return $this->belongsTo('App\Lang');
    }

    //Изначальный язык написания
    public function srcLang()
    {
    	return $this->belongsTo('App\Lang', 'src_lang_id');
    }

    //Файл обложки
    public function cover()
    {
    	return $this->belongsTo('App\File', 'cover_file_id');
    }

    //Файл книги
    public function bookFile()
    {
    	return $this->belongsTo('App\File', 'book_file_id');
    }

    //Список авторов
    public function authors()
    {
    	return $this->belongsToMany('App\Author');
    }

    public function getAuthorsForBookinfoAttribute()
    {
        $authors = $this->authors;

        $result = [];
        foreach($authors as $author)
        {
            $mn = ($author->middle_name !== null ? (' ' . $author->middle_name) : '');

            $result[] = $author->first_name . $mn . ' ' . $author->last_name;
        }

        return $result;
    }

    //Привязанные жанры
    public function genres()
    {
    	return $this->belongsToMany('App\Genre');
    }

    //Глоссарий
    public function terms()
    {
    	return $this->belongsToMany('App\Term');
    }

    public function test()
    {
        return $this->hasOne('App\Models\BookTest\Test');
    }

    //История открытий с процентом прочтения
    public function openHistory()
    {
    	return $this->belongsToMany('App\User', 'book_open_history')->withPivot('opened_at', 'read_percent');
    }
}
