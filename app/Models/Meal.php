<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $table = 'meal';
    protected $fillable = ['name', 'description', 'price', 'catagory_id', 'count'];
    protected $hidden = ['pivot', 'meal_id'];
    public function image_meal()
    {
        return $this->hasOne('App\Models\Image', 'meal_id');
    }

    public function many_meal()
    {
        return $this->belongsTo('App\Models\Catogry', 'catagory_id');
    }

    public function meal_inventory_has_many()
    {
        return $this->belongsToMany('App\Models\Inventory', 'Meal_Inventory', 'meal_id', 'inventory_id');
    }

    /* public function meal_order_has_many()
    {
    return $this->belongsToMany('App\Models\Order_item', 'Order_Meal', 'meal_id', 'order_id');
    }

    public function meal_order_remote_has_many()
    {
    return $this->belongsToMany('App\Models\Order_remote', 'Order_Meal', 'meal_id', 'order_remote_id');
    }
     */
    public function one_meal()
    {
        return $this->hasMany('App\Models\Order_Meal', 'meal_id');
    }

    public function user_order()
    {
        return $this->belongsToMany('App\Models\User', 'Order_Meal', 'meal_id', 'user_id');
    }
}
