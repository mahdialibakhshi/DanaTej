<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Entities\Menu;
use Modules\Admin\Entities\Page;
use Modules\Admin\Entities\Slider;

class PageController extends Controller
{
    public function index($per_page = null)
    {


        if ($per_page == 'all') {
            $row_count = Page::latest()->count();
            $pages = Page::latest()->paginate($row_count);
        } elseif ($per_page == 'default') {
            $pages = Page::latest()->paginate(20);
            $per_page = null;
        } else {
            $pages = Page::latest()->paginate($per_page);
        }


        return view('admin::page.index', compact('pages', 'per_page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $menus = Menu::all();
        return view('admin::page.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $this->validateForm($request);

        try {
            Page::create([
                'menu_id' => $request->menu_id,
                'title_fa' => $request->title_fa,

                'description_fa' => $request->description_fa,

                'short_description_fa' => $request->short_description_fa,


            ]);

            alert()->success('صفحه شما اضافه شد.', 'با تشکر');
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
    public function edit(Page $page)
    {
        $menus = Menu::all();

        return view('admin::page.edit', compact( 'menus','page'));
    }

    public function update(Request $request, Page $page)
    {

        try {
            $this->validateForm($request,$page->id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }


        $page->update([
            'menu_id' => $request->menu_id,
            'title_fa' => $request->title_fa,

            'description_fa' => $request->description_fa,

            'short_description_fa' => $request->short_description_fa,

        ]);


        alert()->success('صفحه شما با موفقیت ویرایش شد.', 'با تشکر');

        return redirect()->route('admin.pages.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $page = Page::find($id);
            $page->delete();

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
                $page = Page::find($id);
                $page->delete();
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
            'menu_id' => 'required',
            'title_fa' => 'nullable' ,
            'description_fa' => 'nullable',
            'short_description_fa' => 'nullable',


        ]);
    }

}
