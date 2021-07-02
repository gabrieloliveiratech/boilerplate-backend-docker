<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Action extends Model
{
    //
    protected $fillable = [
        'name',
        'description'
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = Str::slug($value);
    }
}
