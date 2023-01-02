<?php

namespace Modules\Admin\Entities;

use App\Mail\ContactMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['message','email','name','subject'];
//    protected $guarded = [];
    protected $table = 'contacts';


}
