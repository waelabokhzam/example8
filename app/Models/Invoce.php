<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoce extends Model
{
    use HasFactory;

    protected $table = 'invoic';
    protected $fillable = ['user_id', 'total_price', 'status_payment', 'email'];

    public function many_order()
    {
        return $this->belongsTo('App\Models\Order_Meal', 'user_id');
    }
}
