<?php

namespace App\Models\BookTest;

use App\Book;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'id',
        'name',
        'code',
        'book_id',
    ];

    public function getId() : int
    {
        return (int)$this->id;
    }

    public function book()
    {
        return $this->belongsTo('App\Book');
    }

    public function getBook() : Book
    {
        return $this->book;
    }

    public function steps()
    {
        return $this->hasMany('App\Models\BookTest\Step');
    }

    public function getSteps()
    {
        return $this->steps;
    }

    public function attempts()
    {
        return $this->hasMany('App\Models\BookTest\Attempt');
    }

    public function getCode() : string
    {
        return $this->code;
    }

    public function getName() : string
    {
        return $this->name;
    }

}
