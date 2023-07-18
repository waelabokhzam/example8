<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';
    protected $fillable = ['meal_id', 'name', 'count'];
    protected $hidden = ['pivot'];
    public function inventory_meal_has_many()
    {
        return $this->belongsToMany('App\Models\Meal', 'Meal_Inventory', 'inventory_id', 'meal_id');
    }
}
