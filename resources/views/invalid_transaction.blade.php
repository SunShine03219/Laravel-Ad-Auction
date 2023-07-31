@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')


    <div class="page-header search-page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if( ! empty($title)) <h2>{{ $title }} </h2> @endif
                    <div class="btn-group btn-breadcrumb">
                        <a href="{{route('home')}}" class="btn btn-warning"><i class="glyphicon glyphicon-home"></i></a>
                        <a href="javascript:;" class="btn btn-warning"> @lang('app.invalid_transaction')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="payment-success-wrap">
                    <h2><i class="fa fa-info-circle"></i> @lang('app.invalid_transaction') </h2>
                </div>

            </div>
        </div>
    </div>


@endsection