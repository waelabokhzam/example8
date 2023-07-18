<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catogry extends Model
{
    use HasFactory;

    protected $table = 'catagory';
    protected $fillable = ['name', 'tabel_id'];

    public function image_catagory()
    {
        return $this->hasOne('App\Models\Image', 'catagory_id');
    }

    public function table()
    {
        return $this->belongsTo('App\Models\Tabel', 'tabel_id');
    }

    public function one_catagory()
    {
        return $this->hasMany('App\Models\Meal', 'catagory_id');
    }
}
