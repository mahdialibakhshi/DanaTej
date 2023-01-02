<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Entities\Blog;
use Modules\Admin\Entities\Menu;
use Modules\Admin\Entities\Project;


class ProjectController extends Controller
{
    public function index($per_page = null)
    {

        if ($per_page === 'all') {
            $row_count = Project::latest()->count();
            $projects = Project::latest()->paginate($row_count);
        } elseif ($per_page == 'default') {
            $projects = Project::latest()->paginate(20);
            $per_page = null;
        } else {
            $projects = Project::latest()->paginate($per_page);
        }

        return view('admin::project.index', compact('projects', 'per_page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $menus = Menu::all();
        return view('admin::project.create',compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateForm($request);

        $image_name = $this->saveFile($request->image, 'UPLOAD_PROJECT_IMAGES');

        try {
            $project = Project::create([
                'title_fa' => $request->title_fa,
                'description_fa' => $request->description_fa,
                'image' => $image_name,

                'short_description_fa' => $request->short_description_fa,

                'alias' => $request->alias ?? str_replace([' ', '_'], ['-', '-'], $request->title_fa),
            ]);
            $menus = $request->menus_id;
            foreach ($menus as $menu){

                $project->menus()->attach($menu);
            }

        } catch (\Throwable $e) {
            alert()->error('متاسفانه عملیات با خطا مواجه شد.', 'خطا');
        }



        alert()->success('پروژه شما اضافه شد.', 'با تشکر');
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
    public function edit(Project $project)
    {
        $menus = Menu::all();

        return view('admin::project.edit', compact( 'menus','project'));
    }

    public function update(Request $request, Project $project)
    {


        $this->validateForm($request,$project->id);

        if ($request->has('image')) {
            Storage::delete('public/images/projects/' . $project->image);
            $image_name = $this->saveFile($request->image, 'UPLOAD_PROJECT_IMAGES');
        } else {
            $image_name = $project->image;
        }


        $project->update([
            'title_fa' => $request->title_fa,
            'description_fa' => $request->description_fa,
            'image' => $image_name,

            'short_description_fa' => $request->short_description_fa,

            'alias' => $request->alias ?? str_replace([' ', '_'], ['-', '-'], $request->title_fa),
        ]);

        $menus = $request->menus_id;
        if (!is_null($menus)){
            foreach ($menus as $menu){
                $project->menus()->syncWithoutDetaching($menu);
            }
        }



        alert()->success('پروژه شما با موفقیت ویرایش شد.', 'با تشکر');

        return redirect()->route('admin.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $project = Project::find($id);
            Storage::delete('public/images/projects/' . $project->image);
            $project->delete();
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
                $project = Project::find($id);
                Storage::delete('public/images/projects/' . $project->image);
                $project->delete();

            }
            return \response()->json([1, 'حذف با موفقیت انجام شد']);
        } catch (\Expectation $e) {
            Log::error($e->getMessage());
            return \response()->json([0, 'خطا در انجام عملیات']);
        }
    }

//    public function validateForm(Request $request)
//    {
//        $request->validate([
//            'title_fa' => 'required',
//            'description_fa' => 'required',
//            'image' => ['required', 'image'],
//            'title_en' => 'nullable',
//            'description_en' => 'nullable',
//        ]);
//    }
    public function validateForm(Request $request,$id = null)
    {
        $request->validate([
            'menus_id' => 'nullable',
            'title_fa' => 'nullable',

            'description_fa' => 'nullable',

            'short_description_fa' => 'nullable',

            'alias' => 'nullable|unique:blogs,alias,' . $id ,
            'image' => ['nullable', 'image'],

        ]);
    }

    public function saveFile($file, $env)
    {
        if (is_file($file)) {
            $destination_path = env($env);
            $new_file = $file;
            $file_name = time() . "." . $new_file->getClientOriginalExtension();
            $path = $file->storeAs($destination_path, $file_name);
            return $file_name;
        };
        return 'File Not Found';
    }
}
