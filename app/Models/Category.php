<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort',
        'active',
    ];

    public $casts = [
        'name'          => 'string' ,
        'description'   => 'string',
        'sort'          => 'integer',
        'active'        => 'boolean'
    ];
}
