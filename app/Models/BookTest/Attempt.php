<?php

namespace App\Models\BookTest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Attempt extends Model
{
    protected $fillable = [
        'id',
        'test_id',
        'user_id',
        'start_date',
        'end_date',
    ];

    public function getId() : int
    {
        return $this->id;
    }

    public function test()
    {
        return $this->belongsTo('App\Models\BookTest\Test');
    }

    public function getTest()
    {
        return $this->test;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getUser()
    {
        return $this->user;
    }

    public function attemptJournal()
    {
        return $this->hasMany('App\Models\BookTest\Journal');
    }

    public function getAttemptJournal()
    {
        return $this->attemptJournal;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function isActive() : bool
    {
        return $this->getEndDate() instanceof Date;
    }

    public function getScore() : int
    {
        return (int)$this->score;
    }


}
