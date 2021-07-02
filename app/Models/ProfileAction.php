<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileAction extends Model
{
    //
    protected $fillable = [
        'action_id', 'profile_id'
    ];
    public function action(){
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }
}
