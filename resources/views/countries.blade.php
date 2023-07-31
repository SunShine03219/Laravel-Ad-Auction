@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

   <div class="page-header">
       <div class="container">
           <div class="row">
               <div class="col-md-12">
                   @if( ! empty($title)) <h2>{{ $title }} </h2> @endif
                   <div class="btn-group btn-breadcrumb">
                       <a href="{{route('home')}}" class="btn btn-warning"><i class="fa fa-home"></i></a>
                       <a href="{{route('countries')}}" class="btn btn-warning">@lang('app.countries')</a>

                       @if($is_all_states)
                           <a href="{{route('countries', $current_country['country_code'])}}" class="btn btn-warning">@lang('app.all_states')</a>
                       @endif
                   </div>
               </div>
           </div>
       </div>
   </div>

   @if($is_all_states && $country->states->count())
       <div class="single-categories-more">
           <div class="container">
               <div class="row">
                   @foreach($country->states as $state)
                       <div class="col-md-3">
                           <div class="single-category-title"><a href="#"><i class="fa fa-map-marker"></i> {{$state->state_name}}</a></div>
                       </div>
                   @endforeach
               </div>

               <div class="row">
                   <div class="col-md-12">
                       <hr />
                       <h3>@lang('app.more_countries')</h3>
                   </div>
               </div>

           </div>
       </div>
   @endif

   @if($countries->count())
        <div class="container">
            <div class="row equal">
                @foreach($countries as $country)
                    <div class="col-md-3">
                        <div class="country-name">
                            <a href="{{route('set_country', $country->country_code)}}">
                                @if($country->flag && file_exists(public_path('assets/flags/16/'.strtolower($country->flag) )))
                                    <img src="{{asset('assets/flags/16/'.strtolower($country->flag) )}}" />
                                @endif
                                {{$country->country_name}}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection
