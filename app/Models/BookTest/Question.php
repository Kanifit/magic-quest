<?php

namespace App\Models\BookTest;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'id',
        'title',
        'step_id',
        'sort',
    ];

    public function getId() : int
    {
        return $this->id;
    }

    public function step()
    {
        return $this->belongsTo('App\Models\BookTest\Step');
    }

    public function getStep()
    {
        return $this->step;
    }

    public function answers()
    {
        return $this->hasMany('App\Models\BookTest\Answer');
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getSort() : int
    {
        return $this->sort;
    }
}
