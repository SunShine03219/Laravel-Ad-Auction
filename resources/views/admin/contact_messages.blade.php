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

                        @if($contact_messages->count())
                            <table class="table table-bordered table-striped" >
                                <tr>
                                    <th>@lang('app.name')</th>
                                    <th>@lang('app.email')</th>
                                    <th>@lang('app.message')</th>
                                    <th>@lang('app.created_at')</th>
                                </tr>

                                @foreach($contact_messages as $message)
                                    <tr>
                                        <td>{!! $message->name !!}</td>
                                        <td>{!! $message->email !!}</td>
                                        <td>{!! $message->message !!}</td>
                                        <td>{!! $message->created_at_datetime() !!}</td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $contact_messages->links() !!}
                        @else
                            <div class="alert alert-info">No data</div>
                        @endif

                    </div>
                </div>

            </div>   <!-- /#page-wrapper -->

        </div>   <!-- /#wrapper -->


    </div> <!-- /#container -->
@endsection