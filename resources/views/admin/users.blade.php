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

                        <table class="table table-bordered table-striped" >
                            <tr>
                                <th>@lang('app.name')</th>
                                <th>@lang('app.email')</th>
                                <th>@lang('app.created_at')</th>
                            </tr>
                            
                            @foreach($users as $user)
                                <tr>
                                    <td><a href="{{route('user_info', $user->id)}}">{{$user->name}}</a></td>
                                    <td>{!! $user->email !!}</td>
                                    <td>{!! $user->signed_up_datetime() !!}</td>
                                </tr>
                            @endforeach
                        </table>

                        {!! $users->links() !!}

                    </div>
                </div>

            </div>   <!-- /#page-wrapper -->

        </div>   <!-- /#wrapper -->

    </div> <!-- /#container -->
@endsection