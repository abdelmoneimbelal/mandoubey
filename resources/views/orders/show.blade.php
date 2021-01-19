@extends('layouts.master')
@section('css')
    <!--Internal  Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>
    <!-- Internal Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('title')
    تفاصيل الطلب
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">تفاصيل الطلب</h2>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body h-100">
                    <div class="row row-sm ">
                        <div class=" col-xl-5 col-lg-12 col-md-12">
                            <div class="preview-pic tab-content">
                                <div class="tab-pane active" id="pic-1">
                                    <img src="{{asset($orders->image)}}" alt="image"/>
                                </div>

                            </div>

                        </div>
                        <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                            <h4 class="product-title mb-1">{{$orders->section->name}}</h4>
                            <h6 class="price h3">السعر : <span class="h4 ml-2">{{$orders->price}}</span></h6>
                            <h6 class="price h3">سعر الشحن : <span class="h4 ml-2">{{$orders->shipping_price}}</span>
                            </h6>
                            <h6 class="price h3">الهاتف : <span class="h4 ml-2">{{$orders->phone}}</span></h6>
                            <h6 class="price h3">اسم المستلم : <span class="h4 ml-2">{{$orders->name}}</span></h6>
                            <h6 class="price h3">اسم العميل : <span class="h4 ml-2">{{$orders->client->name}}</span>
                            </h6>
                            @if($orders->delegate_id != '')
                                <h6 class="price h3">اسم المندوب : <span
                                            class="h4 ml-2">{{$orders->delegate->name}}</span>
                                </h6>
                            @else
                                <h6 class="price h3">اسم المندوب : <span
                                            class="badge badge-pill badge-danger text-white">جارى الانتظار</span>
                                </h6>
                            @endif
                            @if($orders->payment_method === 'before')
                                <h6 class="price h3">طريقة الدفع : <span
                                            class="badge badge-pill badge-danger text-white">قبل التوصيل</span>
                                </h6>
                            @elseif($orders->payment_method === 'after')
                                <h6 class="price h3">طريقة الدفع : <span
                                            class="badge badge-pill badge-danger text-white">بعد التوصيل</span>
                                </h6>
                            @else
                                <h6 class="price h3">طريقة الدفع : <span
                                            class="badge badge-pill badge-danger text-white">بدون تحديد</span>
                                </h6>
                            @endif
                            @if($orders->type === 'male')
                                <h6 class="price h3">نوع المندوب : <span
                                            class="badge badge-pill badge-danger text-white">ذكر</span>
                                </h6>
                            @elseif($orders->type === 'female')
                                <h6 class="price h3">نوع المندوب : <span
                                            class="badge badge-pill badge-danger text-white">انثى</span>
                                </h6>
                            @else
                                <h6 class="price h3">نوع المندوب : <span
                                            class="badge badge-pill badge-danger text-white">بدون تحديد</span>
                                </h6>
                            @endif
                            <h6 class="price h3">رقم الطلب : <span class="h4 ml-2">{{$orders->delivery_number}}</span>
                            </h6>
                            <h6 class="price h3">من : <span class="h4 ml-2">{{$orders->address}}</span>
                                <h6 class="price h3">الى : <span class="h4 ml-2">{{$orders->address2}}</span>
                                    <h6 class="price h3">وصف الطلب : <span class="h4 ml-2">{{$orders->notes}}</span>
                                    </h6>
                                    <h6 class="price h3">الوزن : <span class="h4 ml-2">{{$orders->weight}} KG</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>
    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>
@endsection