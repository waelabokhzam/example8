<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Meal extends Model
{
    use HasFactory;
    protected $table = 'order_meal';
    protected $fillable = ['meal_id', 'user_id', 'user_remote_id', 'count', 'status'];

    public function many_users_remote()
    {
        return $this->belongsTo('App\Models\User_remote', 'user_remote_id');
    }
    public function one_order()
    {
        return $this->hasMany('App\Models\Invoce', 'user_id');
    }
}
