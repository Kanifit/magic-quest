<?php

namespace App\Models\BookTest;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $table = 'step_description';

    protected $fillable = [
        'id',
        'text',
        'step_id',
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

    public function getText() : string
    {
        return $this->text;
    }
}
