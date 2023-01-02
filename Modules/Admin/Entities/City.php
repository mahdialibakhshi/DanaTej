<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'cities';

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\CityFactory::new();
    }
    public function provinces()
    {
        return $this->belongsTo(Province::class,'province_id','id');
    }
}
