<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $table = 'about';
    protected $fillable = ['name', 'job', 'phone'];

    public function image_about()
    {
        return $this->hasOne('App\Models\Image', 'about_id');
    }
}
