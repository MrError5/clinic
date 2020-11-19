<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * Class User
 * @package App\Models
 * @version November 15, 2020, 6:59 pm UTC
 *
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $gender
 * @property integer $age
 * @property string $image
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable
implements \Illuminate\Contracts\Auth\Authenticatable
{
    use LaratrustUserTrait;

    public $table = 'users';


public $guard=[];

    public $fillable = [
        'name',
        'phone',
        'address',
        'gender',
        'age',
        'image',
        'email',
        'password'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'gender' => 'string',
        'age' => 'integer',
        'image' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'gender' => 'required',
        'age' => 'required',
        'image' => 'nullable',
        'email' => 'required|email|unique:users,email',
        'password' => 'required'
    ];


}
