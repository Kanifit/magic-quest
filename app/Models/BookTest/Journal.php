<?php

namespace App\Models\BookTest;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'attempt_journal';

    protected $fillable = [
        'id',
        'attempt_id',
        'step_id',
        'point',
    ];


    public function getId() : int
    {
        return $this->id;
    }

    public function attempt()
    {
        return $this->belongsTo('App\Models\BookTest\Attempt');
    }

    public function getAttempt()
    {
        return $this->attempt;
    }

    public function step()
    {
        return $this->belongsTo('App\Models\BookTest\Step');
    }

    public function getStep()
    {
        return $this->step;
    }

    public function getStepId()
    {
        return $this->stepId;
    }

    public function getPoint()
    {
        return $this->point;
    }
}
