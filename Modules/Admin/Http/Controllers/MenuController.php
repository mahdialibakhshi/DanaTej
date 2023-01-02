<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Modules\Admin\Entities\Menu;
use Modules\Admin\Entities\Slider;
use Nette\Schema\Expect;
use Nette\Schema\ValidationException;
use function PHPUnit\Framework\isEmpty;


class MenuController extends Controller
{
    public function index($per_page = null)
    {


        if ($per_page == 'all') {
            $row_count = Menu::latest()->count();
            $menus = Menu::latest()->paginate($row_count);
        } elseif ($per_page == 'default') {
            $menus = Menu::latest()->paginate(20);
            $per_page = null;
        } else {
            $menus = Menu::latest()->paginate($per_page);
        }


        return view('admin::menu.index', compact('menus', 'per_page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $menus = Menu::all();
        return view('admin::menu.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {



            if(Menu::where([['title_fa','=',$request->title_fa],['parent_id', '=', $request->menu],])->exists()) {

                throw \Illuminate\Validation\ValidationException::withMessages(['menu' => ['نمیتوان دو زیر منو همنام برای هر منو داشت!!!']]);
            }


            $this->validateForm($request);



        try {
            Menu::create([
                'parent_id' => $request->menu,
                'title_fa' => $request->title_fa,

                'alias' => $request->alias ?? str_replace([' ', '_'], ['-', '-'], $request->title_fa),

            ]);

            alert()->success('منو شما اضافه شد.', 'با تشکر');
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
    public function edit(Menu $menu)
    {

        $category_ids = [];
        $ids = [];
        array_push($category_ids,$menu->id);
        array_push($ids,$menu->id);
        do{
            $categories =Menu::whereIn('parent_id',$ids)->get();
            $ids = [];
            if (count($categories) > 0){
                foreach ($categories as $cat){
                    array_push($category_ids,$cat->id);
                    array_push($ids,$cat->id);
                }
            }
        }while(count($categories) > 0);
        $menus = Menu::whereNotIn('id', $category_ids)->get();
        return view('admin::menu.edit', compact('menu', 'menus'));
    }

    public function update(Request $request, Menu $menu)
    {

        try {
//            $request->validate([
//
//                'title_fa' => 'required|unique:menus,title_fa,'.$menu->id,
//                'title_en' => 'nullable',
//                'alias' => ['nullable' ,  Rule::unique('menus')->ignore($menu->id)],
//            ]);
            $this->validateForm($request,$menu->id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }


        $menu->update([
            'parent_id' => $request->menu,
            'title_fa' => $request->title_fa,

            'alias' => $request->alias,
        ]);


        alert()->success('منو شما با موفقیت ویرایش شد.', 'با تشکر');

        return redirect()->route('admin.menus.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $this->removeFunction($id);
//            $menus = Menu::all();
//            foreach ($menus as $menu_child){
//                $idm = $menu_child->parent_id;
//                $menu_exists= Menu::where('id' , $idm)->get();
//                if(isEmpty($menu_exists)){
//                    $menu_child->delete();
//                }
//            }
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
                $this->removeFunction($id);
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

            'title_fa' => 'nullable',
            'alias' => 'required|unique:menus,alias,' . $id ,
        ]);
    }

    private function removeFunction($id){
        $menu = Menu::find($id);
        $category_ids = [];
        $ids = [];
        array_push($category_ids,$menu->id);
        array_push($ids,$menu->id);
        do{
            $categories =Menu::whereIn('parent_id',$ids)->get();
            $ids = [];
            if (count($categories) > 0){
                foreach ($categories as $cat){
                    array_push($category_ids,$cat->id);
                    array_push($ids,$cat->id);
                }
            }
        }while(count($categories) > 0);
        Menu::whereIn('id',$category_ids)->delete();
    }
}
