@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <div class="container">
        <div id="wrapper">

            @include('admin.sidebar_menu')

            <div id="page-wrapper">
                @if( ! empty($title))
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"> {{ $title }}  </h1>
                        </div> <!-- /.col-lg-12 -->
                    </div> <!-- /.row -->
                @endif
                @include('admin.flash_msg')

                <div class="row">
                    <div class="col-xs-12">

                        <table class="table table-bordered table-striped table-responsive">
                            <tr>
                                <th>@lang('app.job')</th>
                                <td>{{$ad->title}}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.name')</th>
                                <td>{{$applicant->name}}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.email')</th>
                                <td>{{$applicant->email}}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.phone_number')</th>
                                <td>{{$applicant->phone_number}}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.message')</th>
                                <td>{!! nl2br($applicant->message) !!}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.resume')</th>
                                <td>
                                    <a href="{{resume_url($applicant->resume)}}" class="btn btn-info"><i class="fa fa-download"></i> @lang('app.download') </a>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>

            </div>   <!-- /#page-wrapper -->

        </div>   <!-- /#wrapper -->


    </div> <!-- /#container -->
@endsection

@section('page-js')

@endsection