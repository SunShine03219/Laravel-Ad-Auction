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

                        @if($applicants->total() > 0)
                            <table class="table table-bordered table-striped table-responsive">
                                <tr>
                                    <th>@lang('app.name')</th>
                                    <th>@lang('app.email')</th>
                                    <th>@lang('app.resume')</th>
                                </tr>

                                @foreach($applicants as $applicant)
                                    <tr>
                                        <td>{{$applicant->name}}</td>
                                        <td>{{$applicant->email}}</td>
                                        <td>
                                            <a href="{{resume_url($applicant->resume)}}" class="btn btn-info"><i class="fa fa-download"></i> @lang('app.download') </a>
                                            <a href="{{route('job_applicant_view', $applicant->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i> </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif

                        {!! $applicants->links() !!}

                    </div>
                </div>

            </div>   <!-- /#page-wrapper -->

        </div>   <!-- /#wrapper -->


    </div> <!-- /#container -->
@endsection

@section('page-js')

@endsection