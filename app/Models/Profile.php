<?php

namespace App\Models;

use App\Traits\ModelTransform;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use ModelTransform;
    //

    public $transformer = \App\Transformers\ProfileTransformer::class;

    protected $fillable = [
        'name'
    ];

    public function actions(){
        return $this->hasMany(ProfileAction::class, 'profile_id');
    }

}
