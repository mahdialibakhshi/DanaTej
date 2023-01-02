<?php

namespace Modules\Admin\Http\Controllers;


use http\Env\Response;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\Expectation;
use Modules\Admin\Entities\Slider;

class SliderController extends Controller
{
    protected $env='UPLOAD_SLIDER_IMAGES';

    public function index($per_page = null)
    {

        if ($per_page === 'all') {
            $row_count = Slider::latest()->count();
            $sliders = Slider::latest()->paginate($row_count);
        } elseif ($per_page == 'default') {
            $sliders = Slider::latest()->paginate(20);
            $per_page = null;
        } else {
            $sliders = Slider::latest()->paginate($per_page);
        }
        return view('admin::slider.index', compact('sliders', 'per_page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::slider.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateForm($request);

        $image_name = saveFile($request->image, $this->env);

        try {
            Slider::create([
                'title_fa' => $request->title_fa,
                'btn_fa' => $request->btn_fa,
                'description_fa' => $request->description_fa,
                'btn_link' => $request->btn_link,
                'image' => $image_name,

            ]);
            alert()->success('اسلایدر شما اضافه شد.', 'با تشکر');
        } catch (\Throwable $e) {
            alert()->error('متاسفانه عملیات با خطا مواجه شد.', 'خطا');
        }

        return redirect()->back();


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin::slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {

        $this->validateForm($request,true);

        if ($request->has('image')) {
            unlink_image_helper_function(env($this->env).$slider->image);
            $image_name = saveFile($request->image, $this->env);
        } else {
            $image_name = $slider->image;
        }


        $slider->update([
            'title_fa' => $request->title_fa,
            'btn_fa' => $request->btn_fa,
            'description_fa' => $request->description_fa,
            'btn_link' => $request->btn_link,
            'image' => $image_name,

        ]);


        alert()->success('اسلایدر شما با موفقیت ویرایش شد.', 'با تشکر');

        return redirect()->route('admin.sliders.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $slider = Slider::find($id);
            unlink_image_helper_function(env($this->env).$slider->image);
            $slider->delete();
            return \response()->json([1, 'حذف با موفقیت انجام شد']);
        } catch (\Expectation $e) {
            Log::error($e->getMessage());
            return \response()->json([0, 'خطا در انجام عملیات']);
        }


    }

    public function GroupRemove(Request $request)
    {
        $ids = $request->id;
        $ids = explode(',', $ids);
        try {

            foreach ($ids as $id) {
                $slider = Slider::find($id);
                unlink_image_helper_function(env($this->env).$slider->image);
                $slider->delete();

            }
                return \response()->json([1, 'حذف با موفقیت انجام شد']);
        } catch (\Expectation $e) {
            Log::error($e->getMessage());
            return \response()->json([0, 'خطا در انجام عملیات']);
        }
    }

    public function validateForm(Request $request,$update = false)
    {
        $request->validate([
            'title_fa' =>'nullable' ,
            'btn_fa' => 'nullable',
            'description_fa' => 'nullable',
            'btn_link' => 'nullable',
            'image' => $update ? ['nullable','image'] :['required','image'] ,

        ]);
    }
}
