<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'is_admin',
        'email_verified_at',
        'created_at',
        'updated_at',
        'points',
        'remember_token',
    ];


    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean', // garante que is_admin seja booleano
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'remember_token',
    ];

    public function answers()
    {
        return $this->hasMany(\App\Models\Answer::class);
    }

    public function penalties()
    {
        return $this->hasMany(\App\Models\Penalty::class);
    }

}
