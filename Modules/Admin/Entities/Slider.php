<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['title_fa',	'description_fa','btn_fa',	'btn_link','image'];
//    protected $guarded = [];
    protected $table = 'sliders';

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\SliderFactory::new();
    }
}
