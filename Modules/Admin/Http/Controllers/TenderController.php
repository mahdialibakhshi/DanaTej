<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Entities\Blog;
use Modules\Admin\Entities\City;
use Modules\Admin\Entities\Menu;
use Modules\Admin\Entities\Province;
use Modules\Admin\Entities\Tender;

class TenderController extends Controller
{
    public function index($per_page = null)
    {


        if ($per_page == 'all') {
            $row_count = Tender::latest()->count();
            $tenders = Tender::latest()->paginate($row_count);
        } elseif ($per_page == 'default') {
            $tenders  = Tender::latest()->paginate(20);
            $per_page = null;
        } else {
            $tenders  = Tender::latest()->paginate($per_page);

        }
        $cities = City::all();

        return view('admin::tender.index', compact('tenders', 'per_page','cities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {


      $tenders = Tender::all();
        $menus = Menu::all();
        $cities = City::all();
        $provinces = Province::all();
        return view('admin::tender.create', compact('tenders','menus','cities','provinces'));
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
            $tender = Tender::create([
                'title_fa' => $request->title_fa,
                'description_fa' => $request->description_fa,
                'city_id' => $request->city_id,

            ]);
            if (!is_null($request->menus_id)){
                $menus = $request->menus_id;
                foreach ($menus as $menu) {
                    $tender->menus()->attach($menu);
                }
            }




            alert()->success('مناقصه شما اضافه شد.', 'با تشکر');
        } catch (\Throwable $e) {
            alert()->error('متاسفانه عملیات با خطا مواجه شد.', 'خطا');
//            dd($e->getMessage().'.'.$e->getLine());
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
    public function edit(Tender $tender)
    {
        $menus = Menu::all();

        $cities = City::all();
        $provinces = Province::all();

        return view('admin::tender.edit', compact( 'menus','tender','provinces','cities'));
    }

    public function update(Request $request, Tender $tender)
    {

        try {
            $this->validateForm($request,$tender->id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }




        $tender->update([
            'title_fa' => $request->title_fa,
            'description_fa' => $request->description_fa,
            'city_id' => $request->city_id,


        ]);

        if (!is_null($request->menus_id)){
            $menus = $request->menus_id;
            foreach ($menus as $menu) {
                $tender->menus()->syncWithoutDetaching($menu);
            }
        }



        alert()->success('مناقصه شما با موفقیت بروزرسانی شد.', 'با تشکر');

        return redirect()->route('admin.tenders.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $tender = Tender::find($id);
            $tender->delete();

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
                $tender = Tender::find($id);
                $tender->delete();
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

            'title_fa' => 'required|unique:tenders,title_fa,' . $id ,
            'description_fa' => 'nullable',
            'city_id' => 'required'

        ]);
    }
}
