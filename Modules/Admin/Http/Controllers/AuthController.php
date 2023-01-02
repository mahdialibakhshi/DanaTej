<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        if (auth()->check()){
            $user = auth()->user();

            if ($user->role == 1){

               return redirect('/admin-panel/management');

            }else{

                return redirect()->route('home');
            }

        }else{
            redirect('home');
        }
        return view('admin::index');
    }

}
