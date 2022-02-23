<?php

namespace App\Models\BookTest;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'step_files';

    protected $fillable = [
        'id',
        'name',
        'step_id',
        'path',
        'mime',
        'size'
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

    public function getName() : string
    {
        return $this->name;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getMimeType() : string
    {
        return $this->mime;
    }

    public function getSize() : string
    {
        return $this->size;
    }
}
