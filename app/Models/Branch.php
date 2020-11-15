<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Branch
 * @package App\Models
 * @version November 14, 2020, 3:59 pm UTC
 *
 * @property string $name
 * @property string $address
 * @property string $phone
 */
class Branch extends Model
{

    public $table = 'branches';
    



    public $fillable = [
        'name',
        'address',
        'phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'address' => 'string',
        'phone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'slug' => 'nullable',
        'address' => 'nullable',
        'phone' => 'nullable'
    ];

    
}
