<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'provinces';

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\ProvinceFactory::new();
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
