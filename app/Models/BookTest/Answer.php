<?php

namespace App\Models\BookTest;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'id',
        'title',
        'question_id',
        'sort',
        'point',
        'next_step_id',
    ];

    public function getId() : int
    {
        return $this->id;
    }

    public function question()
    {
        return $this->belongsTo('App\Models\BookTest\Question');
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getSort() : int
    {
        return $this->sort;
    }

    public function getPoint() : int
    {
        return $this->point;
    }

    public function getNextStep() : int
    {
        return $this->next_step_id;
    }
}
