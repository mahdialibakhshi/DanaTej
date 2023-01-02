<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title_fa','image','short_description_fa'];
//    protected $guarded = [];
    protected $table = 'services';

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\ServiceFactory::new();
    }
}
