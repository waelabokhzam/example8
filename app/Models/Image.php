<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'image';
    protected $fillable = ['image', 'meal_id', 'about_id', 'catagory_id'];
    protected $hidden = ['catagory_id', 'meal_id', 'about_id'];

    public function catagory()
    {
        return $this->belongsTo('App\Models\Catogry', 'catagory_id');
    }

    public function meal()
    {
        return $this->belongsTo('App\Models\Meal', 'meal_id');
    }

    public function about()
    {
        return $this->belongsTo('App\Models\About', 'about_id');
    }
}
