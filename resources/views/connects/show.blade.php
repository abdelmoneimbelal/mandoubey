@extends('layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('title')
    البريد
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h2 class="content-title mb-0 my-auto">البريد</h2>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <!-- /Col -->
        <div class=" col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        @if ($connects->type === 'problems')
                            <span class="label text-success d-flex">
                                               <span class="badge badge-pill badge-warning">المشاكل</span>
                                            </span>
                        @elseif($connects->type === 'suggestions')
                            <span class="label text-success d-flex">
                                                <span class="badge badge-pill badge-success">الاقتراحات</span>
                                            </span>
                        @elseif($connects->type === 'balance')
                            <span class="label text-success d-flex">
                                               <span class="badge badge-pill badge-info">الرصيد</span>
                                            </span>
                        @else
                            <span class="label text-success d-flex">
                                                <span class="badge badge-pill badge-dark">اخرى</span>
                                            </span>
                        @endif
                    </h2>
                </div>
                <div class="card-body">
                    <div class="email-media">
                        <div class="mt-0 d-sm-flex">
                            <img class="ml-2 rounded-circle avatar-xl" src="
                            @if($connects->client_id != '')
                            {{asset($connects->client->photo)}}
                            @elseif($connects->delegate_id != '')
                            {{asset($connects->delegate->photo)}}
                            @endif "
                                 alt="avatar">
                            <div class="media-body">
                                <div class="float-left d-none d-md-flex fs-15">
                                    <span class="mr-3">{{$connects->created_at}}</span>
                                </div>
                                <div class="media-title  font-weight-bold mt-3">
                                    @if($connects->client_id != '')
                                        {{$connects->client->name}} :
                                    @elseif($connects->delegate_id != '')
                                        {{$connects->delegate->name}} :
                                    @endif
                                    <span class="text-muted">
                                        @if($connects->client_id != '')
                                            ({{$connects->client->email}})
                                        @elseif($connects->delegate_id != '')
                                            ({{$connects->delegate->email}})
                                        @endif
                                    </span>
                                </div>
                                <small class="mr-2 d-md-none">{{$connects->created_at}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="eamil-body mt-5">
                        <h6>Hi Sir/ {{Auth::user()->name}}</h6>
                        <p>{{$connects->content}}</p>
                        <hr>
                        <div class="email-attch">
                            <div class="d-sm-flex">
                                <div class=" m-2">
                                    <a href="#"><img class="wd-150 mb-2" src="{{asset($connects->image)}}"
                                                     alt="placeholder image"></a>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection