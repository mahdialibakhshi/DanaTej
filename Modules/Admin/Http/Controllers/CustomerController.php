<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Entities\Customer;
use Modules\Admin\Entities\Slider;

class CustomerController extends Controller
{
    protected $env='UPLOAD_CUSTOMER_IMAGES';

    public function index($per_page = null)
    {

        if ($per_page === 'all') {
            $row_count = Customer::latest()->count();
            $customers = Customer::latest()->paginate($row_count);
        } elseif ($per_page == 'default') {
            $customers = Customer::latest()->paginate(20);
            $per_page = null;
        } else {
            $customers = Customer::latest()->paginate($per_page);
        }
        return view('admin::customer.index', compact('customers', 'per_page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::customer.create');
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
            Customer::create([
                'title' => $request->title,
                'logo' => $image_name,
            ]);
            alert()->success('مشتری شما اضافه شد.', 'با تشکر');
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
        $customer = Customer::find($id);
        return view('admin::customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {

        $this->validateForm($request,true);

        if ($request->has('image')) {
            unlink_image_helper_function(env($this->env) . $customer->logo);
            $image_name = saveFile($request->image, $this->env);
        } else {
            $image_name = $customer->logo;
        }


        $customer->update([
            'title' => $request->title,
            'logo' => $image_name,
        ]);


        alert()->success('مشتری شما با موفقیت ویرایش شد.', 'با تشکر');

        return redirect()->route('admin.customers.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::find($id);
            unlink_image_helper_function(env($this->env).$customer->logo);
            $customer->delete();
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
                $customer = Customer::find($id);
                unlink_image_helper_function(env($this->env).$customer->logo);
                $customer->delete();

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
            'title' =>'nullable' ,
            'logo' =>['nullable','image'] ,

        ]);
    }
}
