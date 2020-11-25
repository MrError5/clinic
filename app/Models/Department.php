<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class Department
 * @package App\Models
 * @version November 25, 2020, 8:48 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $branches
 * @property string $name
 * @property string $note
 */
class Department extends Model
{

    public $table = 'departments';
    



    public $fillable = [
        'name',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'note' => 'string',
        'active' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'note' => 'required',
        'active' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function branches()
    {
        return $this->belongsToMany(\App\Models\Branch::class);
    }
}
