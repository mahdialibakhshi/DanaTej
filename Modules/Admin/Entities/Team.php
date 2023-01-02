<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['title_fa','image','name'];
//    protected $guarded = [];
    protected $table = 'teams';

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\TeamFactory::new();
    }
}
