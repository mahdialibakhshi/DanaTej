<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['title_fa','parent_id','alias'];
//    protected $guarded = [];
    protected $table = 'menus';

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\MenuFactory::new();
    }
    public static function parentTitle($id)
    {

       $menu = Menu::find($id);
       if ($menu->parent_id == 0){
           return 'والد اصلی';
       }
       $parentMenu = Menu::find($menu->parent_id);
       return $parentMenu->title_fa ?? null;
    }
    public function page()
    {
        return $this->hasOne(Page::class);
    }
    public function blogs()
    {
        return $this->belongsToMany(Blog::class,'menu_blog');
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class,'project_menu');
    }
    public function childs() {
        return $this->hasMany(Menu::class,'parent_id','id') ;
    }
    public function tenders()
    {
        return $this->hasMany(Tender::class,'menu_tender');
    }

}
