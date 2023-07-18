<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_remote extends Model
{
    use HasFactory;

    protected $table = 'order_remote';
    protected $fillable = ['user_remote_id', 'count'];

    public function many_users_remote()
    {
        return $this->belongsTo('App\Models\User_remote', 'user_remote_id');
    }

    public function one_order_remote()
    {
        return $this->hasMany('App\Models\Invoce', 'order_remote_id');
    }
    public function order_remote_meal_has_many()
    {
        return $this->belongsToMany('App\Models\Meal', 'Order_Meal', 'order_remote_id', 'meal_id');
    }

}
