<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Entities\Service;
use Modules\Admin\Entities\Team;

class TeamController extends Controller
{
    public function index($per_page = null)
    {

        if ($per_page === 'all') {
            $row_count = Team::latest()->count();
            $teams = Team::latest()->paginate($row_count);
        } elseif ($per_page == 'default') {
            $teams = Team::latest()->paginate(20);
            $per_page = null;
        } else {
            $teams = Team::latest()->paginate($per_page);
        }
        return view('admin::team.index', compact('teams', 'per_page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::team.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateForm($request);

        $image_name = $this->saveFile($request->image, 'UPLOAD_TEAM_IMAGES');



        try {
            Team::create([
                'title_fa' => $request->title_fa,

                'image' => $image_name,
                'name' => $request->name,


            ]);
            alert()->success('مدیر شما اضافه شد.', 'با تشکر');
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
        $team = Team::find($id);
        return view('admin::team.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {

        $this->validateForm($request,true);

        if ($request->has('image')) {
            Storage::delete('public/images/teams/' . $team->image);
            $image_name = $this->saveFile($request->image, 'UPLOAD_TEAM_IMAGES');
        } else {
            $image_name = $team->image;
        }



        $team->update([
            'title_fa' => $request->title_fa,

            'name' => $request->name,
            'image' => $image_name,

        ]);


        alert()->success('مدیر شما با موفقیت ویرایش شد.', 'با تشکر');

        return redirect()->route('admin.teams.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $team = Service::find($id);
            Storage::delete('public/images/teams/' . $team->image);
            $team->delete();
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
                $team = Team::find($id);
                Storage::delete('public/images/teams/' . $team->image);
                $team->delete();

            }
            return \response()->json([1, 'حذف با موفقیت انجام شد']);
        } catch (\Expectation $e) {
            Log::error($e->getMessage());
            return \response()->json([0, 'خطا در انجام عملیات']);
        }
    }

    public function validateForm(Request $request)
    {
        $request->validate([
            'title_fa' =>'nullable' ,

            'name' =>'required' ,

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
