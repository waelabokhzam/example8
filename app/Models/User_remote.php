<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_remote extends Model
{
    use HasFactory;

    protected $table = 'user_remote';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'city',
        'street',
        'countryside',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function one_user_remote()
    {
        return $this->hasMany('App\Models\Order_Meal', 'user_remote_id');
    }
}
