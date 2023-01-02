<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title_fa',	'description_fa',  'image','alias','short_description_fa'];
//    protected $guarded = [];
    protected $table = 'projects';
    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\ProjectFactory::new();
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class,'project_menu');
    }
}
