<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['title_fa',	'logo',	'short_description_fa','address_fa',	'email'	,'fax',	'tel'];
    protected $table = 'settings';

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\SettingFactory::new();
    }
}
