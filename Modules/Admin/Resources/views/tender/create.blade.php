@extends('admin::layouts.master')

@section('title')
    ایجاد مناقصه
@endsection

@section('description')

@endsection

@section('keywords')
    داشبورد
@endsection

@section('style')

@endsection

@section('script')
    <script>
        // Show File Name
        $('#image').change(function () {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $('.custom-file-label').html(fileName);
        });
        $('.selectpicker').selectpicker({
            title: 'منو را انتخاب کنید'
        });
        let province_tag = $('#province');

        let city = $('#city');
        // let options  = $('#city').find('option');
        let options = Array.from(document.getElementById('city').children);




        province_tag.on('change',function (){

        options.forEach(function (option){

             if(province_tag.val() == option.getAttribute('data-province')){
                 option.style.display = 'block';
             }else {
                 option.style.display = 'none';
             }
        })

        });


    </script>
@endsection

@section('content')
    <main id="main" class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="pagetitle d-flex justify-content-between">
                                        <h1>افزودن مناقصه</h1>
                                        <div>
                                            <button onclick="SaveForm('save','form')" class="btn btn-sm btn-success">
                                                save
                                            </button>
                                            <a title="بازگشت" href="{{ route('admin.tenders.index') }}"
                                               class="btn btn-secondary btn-sm">
                                                <i class="bi bi-arrow-bar-left"></i>
                                            </a>
                                        </div>
                                    </div><!-- End Page Title -->

                                </div>
                            </div>
                            <form method="POST" id="form" action="{{route('admin.tender.store')}} ">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                                            <li class="nav-item flex-fill" role="presentation">
                                                <button class="nav-link w-100 active"
                                                        id="profile-tab"
                                                        data-bs-toggle="tab"
                                                        data-bs-target="#fa_setting"
                                                        type="button" role="tab" aria-controls="profile"
                                                        aria-selected="false"><span style="font-size: 17px;float: left;display: {{ ($errors->has('title_fa'))  ? 'block' : 'none' }}" class="badge-error badge rounded-pill bg-danger"> ! </span>تنظیمات
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="tab-content pt-2" id="myTabjustifiedContent">
                                            <div class="tab-pane fade show active"
                                                 id="fa_setting" role="tabpanel" aria-labelledby="home-tab">
                                                <section class="section dashboard tab-pane fade show active mt-5"
                                                         id="home-justified"
                                                         role="tabpanel"
                                                         aria-labelledby="home-tab">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12 mb-2">
                                                            <label for="title_fa" class="form-label">عنوان :</label>
                                                            <input type="text" class="form-control" id="title_fa"
                                                                   name="title_fa" value="{{ old('title_fa') }}">
                                                            @error('title_fa')
                                                            <div class="validate_error">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 mb-2 col-12 position-relative">
                                                            <label for="menu" class="form-label mb-3">انتخاب دسته بندی
                                                                :</label>
                                                            <select  multiple="multiple" class="selectpicker form-control" name="menus_id[]" id="menu">

                                                                @foreach($menus as $menu)
                                                                    <option value="{{$menu->id}}">{{$menu->title_fa  }}</option>
                                                                @endforeach
                                                            </select>

                                                            @error('menu_id')
                                                            <div class="validate_error">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 mb-2 col-12 position-relative">
                                                            <label for="province" class="form-label mb-3">انتخاب استان
                                                                :</label>
                                                            <select class="form-select" name="province_id" id="province">
                                                                <option value="" selected>استان را انتخاب کنید</option>
                                                                @foreach($provinces as $province)
                                                                    <option value="{{$province->id}}">{{$province->name  }}</option>
                                                                @endforeach
                                                            </select>

                                                            @error('province_id')
                                                            <div class="validate_error">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 mb-2 col-12 position-relative">
                                                            <label for="city" class="form-label mb-3">انتخاب شهر
                                                                :</label>
                                                            <select class="form-select" name="city_id" id="city">
                                                                <option value="" selected>شهر را انتخاب کنید</option>
                                                                @foreach($cities as $city)
                                                                    <option style="display: none" data-province="{{$city->province_id}}" value="{{$city->id}}">{{$city->name  }}</option>
                                                                @endforeach
                                                            </select>

                                                            @error('city_id')
                                                            <div class="validate_error">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="description_fa" class="form-label">توضیحات
                                                                :</label>
                                                            <textarea rows="10" type="text" class="form-control"
                                                                      id="description_fa"
                                                                      name="description_fa">{{ old('description_fa') }}</textarea>
                                                            @error('description_fa')
                                                            <div class="validate_error">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                </section>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
