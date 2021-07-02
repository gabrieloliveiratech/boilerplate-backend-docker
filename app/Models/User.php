<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\ModelTransform;
use EloquentFilter\Filterable;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, ModelTransform, Filterable;

    public $transformer = \App\Transformers\UserTransformer::class;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The validation error messages.
     *
     * @var array
     */
    public static $validationMessages = [
        'error.save' => 'Erro on saving User.',
        'error.not_found' => 'User not found.',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $rules = [
        'name' => 'nullable'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isAdmin()
    {
        return $this->profile->name == Constants::PROFILE_ADMIN;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'profile_id');
    }
}
