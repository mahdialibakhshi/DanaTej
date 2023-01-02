<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Entities\Blog;
use Modules\Admin\Entities\Menu;
use Modules\Admin\Entities\Page;

class BlogController extends Controller
{
    protected $env='UPLOAD_BLOG_IMAGES';
    public function index($per_page = null)
    {


        if ($per_page == 'all') {
            $row_count = Blog::latest()->count();
            $blogs = Blog::latest()->paginate($row_count);
        } elseif ($per_page == 'default') {
            $blogs  = Blog::latest()->paginate(20);
            $per_page = null;
        } else {
            $blogs  = Blog::latest()->paginate($per_page);
        }


        return view('admin::blog.index', compact('blogs', 'per_page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $blogs = Blog::all();
        $menus = Menu::all();
        return view('admin::blog.create', compact('blogs','menus'));
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
            $blog = Blog::create([
                'title_fa' => $request->title_fa,
                'description_fa' => $request->description_fa,
                'short_description_fa' => $request->short_description_fa,
                'alias' => $request->alias ?? str_replace([' ', '_'], ['-', '-'], $request->title_fa),
                'image' => $image_name,

            ]);
            if (!is_null($request->menus_id)){
                $menus = $request->menus_id;
            foreach ($menus as $menu) {
                $blog->menus()->attach($menu);
            }
        }




            alert()->success('مقاله شما اضافه شد.', 'با تشکر');
        } catch (\Throwable $e) {
//            alert()->error('متاسفانه عملیات با خطا مواجه شد.', 'خطا');
            dd($e->getMessage().'.'.$e->getLine());
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
    public function edit(Blog $blog)
    {
        $menus = Menu::all();

        return view('admin::blog.edit', compact( 'menus','blog'));
    }

    public function update(Request $request, Blog $blog)
    {

        try {
            $this->validateForm($request,$blog->id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        if ($request->has('image')) {
            unlink_image_helper_function(env($this->env).$blog->image);
            $image_name = saveFile($request->image, $this->env);
        } else {
            $image_name = $blog->image;
        }


        $blog->update([
            'title_fa' => $request->title_fa,
            'description_fa' => $request->description_fa,
            'short_description_fa' => $request->short_description_fa,
            'alias' => $request->alias ?? str_replace([' ', '_'], ['-', '-'], $request->title_fa),
            'image' => $image_name,
        ]);

        if (!is_null($request->menus_id)){
            $menus = $request->menus_id;
            foreach ($menus as $menu) {
                $blog->menus()->syncWithoutDetaching($menu);
            }
        }



        alert()->success('مقاله شما با موفقیت ویرایش شد.', 'با تشکر');

        return redirect()->route('admin.blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::find($id);
            unlink_image_helper_function(env($this->env).$blog->image);
            $blog->delete();

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
                $blog = Blog::find($id);
                unlink_image_helper_function(env($this->env).$blog->image);
                $blog->delete();
            }
            return \response()->json([1, 'حذف با موفقیت انجام شد']);
        } catch (\Expectation $e) {
            Log::error($e->getMessage());
            return \response()->json([0, 'خطا در انجام عملیات']);
        }
    }

    public function validateForm(Request $request,$id = null)
    {
        $request->validate([
            'menus_id' => 'nullable',
            'title_fa' => 'nullable' ,
            'description_fa' => 'nullable',

            'short_description_fa' => 'nullable',

            'alias' => 'nullable|unique:blogs,alias,' . $id ,
            'image' => ['nullable','mimes:jpeg,jpg,png'] ,

        ]);
    }
}
