<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $fillable = [
    	'id',
        'filename',
        'size',
        'extension',
    ];

    //Получить максимальный размер изображения
    public function getMaxAttribute()
    {
        if (!is_int($this->size))
        {
            $sizes = explode('|', $this->size);

            if (in_array('large', $sizes))
                return Storage::disk('user_uploads')->url($this->filename.'_large.'.$this->extension);
            else
                return $this->getMediumAttribute();
        }
    }

    //Получить средний размер изображения
    public function getMediumAttribute()
    {
        if (!is_int($this->size))
        {
            $sizes = explode('|', $this->size);

            if (in_array('medium', $sizes))
                return Storage::disk('user_uploads')->url($this->filename.'_medium.'.$this->extension);
            else
                return $this->getSmallAttribute();
        }
    }

    //Получить минимальный размер изображения
    public function getSmallAttribute()
    {
        if (!is_int($this->size))
        {
            $sizes = explode('|', $this->size);

            if (in_array('small', $sizes))
                return Storage::disk('user_uploads')->url($this->filename.'_small.'.$this->extension);
            else
                return Storage::disk('user_uploads')->url($this->filename.'.'.$this->extension);;
        }
    }
}
