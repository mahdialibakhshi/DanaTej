<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['logo','title'];

    protected $table = 'customers';

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\CustomerFactory::new();
    }
}
