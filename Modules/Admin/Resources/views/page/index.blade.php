@extends('admin::layouts.master')

@section('title')
    لیست صفحه ها
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
        $(document).ready(function () {
            unChecked_inputes();
        })

        function Remove() {
            let id = $('#id').val();
            let url = '{{ route('admin.page.destroy',['page'=>':page']) }}';
            url = url.replace(':page', id);
            $.ajax({
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                dataType: "json",
                type: 'delete',
                beforeSend: function () {
                    beforeSendProgressBar();
                },
                success: function (msg) {
                    if (msg) {
                        if (msg[0] === 1) {
                            ajaxSuccess(msg);
                        }
                        if (msg[0] === 0) {
                            ajaxSuccess(msg);
                        }
                    }
                },
            })
        }

        function GroupRemove() {
            let id = $('#id').val();
            let url = '{{ route('admin.page.GroupRemove') }}';
            $.ajax({
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                dataType: "json",
                type: 'post',
                beforeSend: function () {
                    beforeSendProgressBar();
                },
                success: function (msg) {
                    if (msg) {
                        if (msg[0] === 1) {
                            ajaxSuccess(msg);
                        }
                        if (msg[0] === 0) {
                            ajaxSuccess(msg);
                        }
                    }
                },
            })
        }

    </script>
@endsection

@section('content')
    <main id="main" class="main">

        <div class="pagetitle d-flex justify-content-between">
            <h1 class="w-50">ییج های صفحه اصلی</h1>
            <div class="d-flex w-50">
                <select onchange="show_per_page(this,'{{ route('admin.pages.index') }}')" class="form-control form-control-sm ms-3">
                    <option {{ $per_page==null ? 'selected' : '' }} value="default">پیش فرض</option>
                    <option {{ $per_page==20 ? 'selected' : '' }} value="20">20 تایی</option>
                    <option {{ $per_page==50 ? 'selected' : '' }} value="50">50 تایی</option>
                    <option {{ $per_page==100 ? 'selected' : '' }} value="100">100 تایی</option>
                    <option {{ $per_page==200 ? 'selected' : '' }} value="200">200 تایی</option>
                    <option {{ $per_page=='all' ? 'selected' : '' }} value="all">همه</option>
                </select>
                <button title="حذف گروهی" class="btn btn-sm btn-danger ms-3" type="button"
                        onclick="RemoveModal(null)">
                    <i class="bi bi-trash-fill"></i>
                </button>
                <a title="اضافه کردن پروژه جدید" href="{{ route('admin.page.create') }}"
                   class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Table with stripped rows -->
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">نام</th>
                                            <th scope="col">منو مرتبط</th>
                                            <th scope="col">عملیات</th>
                                            <th scope="col">
                                                <input class="form-check-input check_box_all_items" type="checkbox">
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pages as $key => $item)

                                            <tr>
                                                <th scope="col">{{ $pages->firstItem()+$key }}</th>
                                                <th scope="col">{{ $item->title_fa ?? $item->title_en }}</th>
                                                <th scope="col">{{$item->menu->title_fa ?? 'منو ندارد'}}</th>
                                                <th scope="col">
                                                    <button title="REMOVE" class="btn btn-sm btn-danger" type="button"
                                                            onclick="RemoveModal({{ $item->id }})">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                    <a title="EDIT" class="btn btn-sm btn-info mr-3"
                                                       href="{{ route('admin.page.edit' , ['page' => $item->id]) }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                </th>
                                                <th>
                                                    <input class="form-check-input check_box_items" type="checkbox"
                                                           value="{{ $item->id }}">
                                                </th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    {{ $pages->render() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin::sections.remove_modal')
        </section>
    </main>
@endsection
