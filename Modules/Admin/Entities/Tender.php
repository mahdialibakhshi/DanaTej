<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = ['title_fa','city_id','description_fa'];
    protected $table = 'tenders';

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\TenderFactory::new();
    }
    public function menus()
    {
        return $this->belongsToMany(Menu::class,'menu_tender');
    }

}
