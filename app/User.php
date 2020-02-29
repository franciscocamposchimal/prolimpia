<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $reference
 * @property string $rol
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property Collect[] $collects
 */
class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'name', 'password', 'reference', 'rol', 'deleted_at', 'created_at', 'updated_at'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'rol',
        'password',
        'deleted_at', 
        'created_at', 
        'updated_at',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collects()
    {
        return $this->hasMany('App\Collect');
    }
}