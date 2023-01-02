@extends('admin::layouts.master')

@section('title')
    ایجاد اسلایدر
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
                                        <h1>ویرایش اسلایدر</h1>
                                        <div>
                                            <button onclick="SaveForm('save','form')" class="btn btn-sm btn-success">
                                                save
                                            </button>
                                            <a title="بازگشت" href="{{ route('admin.sliders.index') }}"
                                               class="btn btn-secondary btn-sm">
                                                <i class="bi bi-arrow-bar-left"></i>
                                            </a>
                                        </div>
                                    </div><!-- End Page Title -->

                                </div>
                            </div>
                            <form method="POST" id="form" action="{{route('admin.slider.update',['slider'=>$slider->id])}} " enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                                            <li class="nav-item flex-fill" role="presentation">
                                                <button class="nav-link w-100 active"
                                                        id="profile-tab"
                                                        data-bs-toggle="tab"
                                                        data-bs-target="#fa_setting"
                                                        type="button" role="tab" aria-controls="profile"
                                                        aria-selected="false"><span style="font-size: 17px;float: left;display: {{ ($errors->has('title_fa') or $errors->has('btn_fa') or $errors->has('description_fa'))  ? 'block' : 'none' }}" class="badge-error badge rounded-pill bg-danger"> ! </span>تنظیمات
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
                                                        <div class="row">
                                                            <img class="image-thumbnail img-thumbnail rounded mx-auto d-block" src="{{imageExist(env('SLIDER_IMAGE_FILE'),$slider->image)}}">
                                                        </div>
                                                        <div class="col-md-6 col-12 position-relative">
                                                            <label for="image" class="form-label mb-3">آپلود تصویر
                                                                :</label>
                                                            <input aria-label="انتخاب کنید" class="form-control"
                                                                   type="file" id="image"
                                                                   name="image" value="{{ $slider->image }}" >
                                                            <label class="custom-file-label"></label>
                                                            @error('image')
                                                            <div class="validate_error">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 col-12">


                                                            <label for="title" class="form-label mb-3">لینک دکمه
                                                                :</label>
                                                            <input type="text" class="form-control" id="btn_link"
                                                                   name="btn_link" value="{{ $slider->btn_link }}">
                                                            @error('btn_link')
                                                            <div class="validate_error">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror


                                                        </div>
                                                        <div class="col-md-6 col-12 mb-2">
                                                            <label for="title_fa" class="form-label">عنوان :</label>
                                                            <input type="text" class="form-control" id="title_fa"
                                                                   name="title_fa" value="{{ $slider->title_fa }}">
                                                            @error('title_fa')
                                                            <div class="validate_error">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-2">
                                                            <label for="btn_fa" class="form-label">دکمه :</label>
                                                            <input type="text" class="form-control" id="btn_fa"
                                                                   name="btn_fa" value="{{ $slider->btn_fa }}">
                                                            @error('btn_fa')
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
                                                                      name="description_fa">{{ $slider->description_fa }}</textarea>
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
