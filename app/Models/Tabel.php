<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tabel extends Model
{
    use HasFactory;
    protected $table = 'tabel';
    protected $fillable = ['number', 'status', 'password', 'user_id'];

    public function catagory_table()
    {
        return $this->hasMany('App\Models\Catogry', 'tabel_id');
    }
    public function many_user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
