<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'middle_name', 
        'last_name', 
        'email', 
        'password', 
        'rang',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Загруженные/созданные книги
    public function createdBooks()
    {
        return $this->hasMany('App\Books');
    }

    //

    //История просмотра
    public function openHistory()
    {
        return $this->belongsToMany('App\Book', 'book_open_history')->withPivot('opened_at', 'read_percent')->orderBy('opened_at', 'DESC');
    }
}
