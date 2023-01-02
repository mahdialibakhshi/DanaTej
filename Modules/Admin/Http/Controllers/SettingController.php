<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Setting;

class SettingController extends Controller
{
    protected $env='UPLOAD_SETTING_IMAGES';
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $settings = Setting::first();
        return view('admin::settings.index',compact('settings'));
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request,$id)
    {

        $settings = Setting::find($id);

        $this->validateForm($request,true);

        if ($request->has('image')) {

            unlink_image_helper_function(env($this->env).$settings->logo);
            $image_name = saveFile($request->image, $this->env);
        } else {
            $image_name = $settings->logo;

        }


        $settings->update([
            'title_fa' => $request->title_fa,
            'address_fa' => $request->address_fa,
            'short_description_fa' => $request->short_description_fa,
            'tel' => $request->tel,
            'email' => $request->email,
            'fax' => $request->fax,
            'logo' => $image_name,

        ]);


        alert()->success('تنظیمات شما با موفقیت اعمال شد.', 'با تشکر');

        return redirect()->route('admin.settings.index');
    }

    public function validateForm(Request $request)
    {
        $request->validate([
            'title_fa' =>'nullable' ,
            'address_fa' => 'nullable',
            'short_description_fa' => 'nullable',
            'tel' => 'nullable',
            'fax' => 'nullable',
            'email' => 'nullable',
            'logo' =>  ['nullable','image'],

        ]);
    }
}
