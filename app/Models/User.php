<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    public const BEARER_SUFFIX = 'kjugq3458uio7t6sadgfkjghkl';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'hash', 'token'
    ];

    public static function getPasswordHash(string $str = '') : string
    {
        return $str ? Hash::make($str) : '';
    }

    public static function getBearerToken(string $str = '') : string
    {
        if (!$str) {
            $str = str_random(20);
        }
        return Hash::make(cos(time()).$str.self::BEARER_SUFFIX);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (!$model->password) {
                // Should NOT use that simple password
                $model->password = str_random(8);
            }
            $model->hash = self::getPasswordHash($model->password);
        });
    }
}
