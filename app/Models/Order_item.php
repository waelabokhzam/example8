<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;

    protected $table = 'order_item';
    protected $fillable = ['user_on_sit', 'user_remote', 'count'];
    public function many_users()
    {
        return $this->belongsTo('App\Models\User', 'user_on_sit');
    }
    public function one_order()
    {
        return $this->hasMany('App\Models\Invoce', 'order_item_id');
    }
    public function order_meal_has_many()
    {
        return $this->belongsToMany('App\Models\Meal', 'Order_Meal', 'order_id', 'meal_id');
    }
}
