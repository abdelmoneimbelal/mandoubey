@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet"/>
    <!---Internal  Owl Carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">

    <!-- Internal RatingThemes css-->
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/ratings.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-1to10.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-movie.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-square.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-pill.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-reversed.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bars-horizontal.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/fontawesome-stars.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/css-stars.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/bootstrap-stars.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/rating/themes/fontawesome-stars-o.css')}}">
@section('title')
    صفحة المندوب
@stop

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h2 class="content-title mb-0 my-auto">صفحة المندوب</h2>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="" src="{{asset($delegates->photo)}}">
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{$delegates->name}}</h5>
                                    <p class="main-profile-name-text">{{$delegates->email}}</p>
                                </div>
                            </div>

                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div>
                                <h6 class="card-title mb-1 text-center">تقييم المندوب</h6>
                            </div>
                            <div class="static-rate text-center fs-30">
                                @if($delegates->ratings == 1)
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                @elseif($delegates->ratings == 2)
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                @elseif($delegates->ratings == 3)
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                @elseif($delegates->ratings == 4)
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                @elseif($delegates->ratings == 5)
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /row -->
        </div>

        <div class="col-lg-8">
            <div class="row row-sm">
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
                    <div class="card ">
                        <div class="card-body">
                            <div class="counter-status d-flex md-mb-0">
                                <div class="counter-icon bg-primary-transparent">
                                    <i class="icon-layers text-primary"></i>
                                </div>
                                <div class="mr-auto">
                                    <h3 class="tx-16 t">الطلبات</h3>
                                    <h2 class="mb-0 tx-22 mb-1 mt-1">
                                        @if($orders !== 0)
                                            {{count($orders)}}
                                        @else
                                            0
                                        @endif
                                    </h2>
                                    <p class="text-muted mb-0 tx-11"><i
                                                class="si si-arrow-up-circle text-success mr-1"></i>increase</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs profile navtab-custom panel-tabs">

                            <li class="">
                                <a href="#profile" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                                class="las la-images tx-15 mr-1"></i></span> <span class="hidden-xs">صورة البطاقه</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                                class="las la-cog tx-16 mr-1"></i></span> <span class="hidden-xs">معلومات المندوب</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content border-left border-bottom border-right border-top-0 p-4">

                        <div class="tab-pane " id="profile">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="border p-1 card thumb">
                                        <a href="#" class="image-popup" title="Screenshot-2"> <img
                                                    src="{{asset($delegates->id_front)}}" class="thumb-img"
                                                    alt="work-thumbnail"> </a>
                                        <h4 class="text-center tx-14 mt-3 mb-0">صورة البطاقه من الامام</h4>
                                        <div class="ga-border"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class=" border p-1 card thumb">
                                        <a href="#" class="image-popup" title="Screenshot-2"> <img
                                                    src="{{asset($delegates->id_back)}}" class="thumb-img"
                                                    alt="work-thumbnail"> </a>
                                        <h4 class="text-center tx-14 mt-3 mb-0">صورة البطاقه من الخلف</h4>
                                        <div class="ga-border"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane active" id="settings">

                            <form role="form" action="{{ route('status-delegates', ['id' => $delegates->id]) }}"
                                  method="post"
                                  autocomplete="off">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="FullName">الاسم</label>
                                    <input type="text" value="{{$delegates->name}}" id="FullName" class="form-control"
                                           readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Email">البريد</label>
                                    <input type="email" value="{{$delegates->email}}" id="Email" class="form-control"
                                           readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Username">رقم الهاتف</label>
                                    <input type="text" value="{{$delegates->phone}}" id="Username" class="form-control"
                                           readonly>
                                </div>
                                <div class="form-group">
                                    <label for="Username">الجنس</label>
                                    <input type="text" value="@if($delegates->type == 'male') ذكر@else انثى@endif"
                                           id="Username" class="form-control tx-18"
                                           readonly>
                                </div>
                                @can('حالة المستخدم')
                                    <div class="row">
                                        <div class="col">
                                            <label for="exampleTextarea">حالة المستخدم</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option selected="true" disabled="disabled">-- حدد حالة المستخدم --
                                                </option>
                                                <option value="active">مفعل</option>
                                                <option value="inactive">غير مفعل</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>

                                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">تغير
                                        حالة
                                        المستخدم
                                    </button>
                                @endcan
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Rating js-->
    <script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/rating/ratings.js')}}"></script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })
    </script>

@endsection
