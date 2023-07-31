@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

   <div class="page-header">
       <div class="container">
           <div class="row">
               <div class="col-md-12">
                   @if( ! empty($title)) <h2>{{ $title }} </h2> @endif
                   <div class="btn-group btn-breadcrumb">
                       <a href="{{route('home')}}" class="btn btn-warning"><i class="glyphicon glyphicon-home"></i></a>
                       <a href="{{route('category')}}" class="btn btn-warning">@lang('app.categories')</a>

                       @if($is_category_single)
                           <a href="{{route('category', $id)}}" class="btn btn-warning">{{$category->category_name}}</a>
                       @endif

                   </div>
               </div>
           </div>
       </div>
   </div>


   @if($is_category_single && $category->sub_categories->count())
       <div class="single-categories-more">
           <div class="container">
               <div class="row">
                   @foreach($category->sub_categories as $sub_c)
                       <div class="col-md-3">
                           <div class="single-category-title"><a href="{{ route('search', [ 'category' => 'cat-'.$sub_c->id.'-'.$sub_c->category_slug]) }}"><i class="fa fa-folder-open-o"></i> {{$sub_c->category_name}}</a></div>
                       </div>
                   @endforeach
               </div>


               <div class="row">
                   <div class="col-md-12">
                       <hr />
                       <h3>@lang('app.more_categories')</h3>
                   </div>
               </div>

           </div>
       </div>
   @endif

    @if($top_categories->count())
        <div class="all-categories">
            <div class="container">
                <div class="row equal">
                    @foreach($top_categories as $top_cat)
                        <div class="col-md-3">
                            <div class="home-cat-box">
                                <div class="home-cat-box-title">
                                    <h3><a href="{{ route('search', [ 'category' => 'cat-'.$top_cat->id.'-'.$top_cat->category_slug]) }}"> {{$top_cat->category_name}} </a> </h3>
                                </div>
                                @if($top_cat->sub_categories->count())
                                    <div class="home-cat-box-content">
                                        <ul>
                                            @foreach($top_cat->sub_categories as $sub_cat)
                                                <li><a href="{{ route('search', [ 'category' => 'cat-'.$sub_cat->id.'-'.$sub_cat->category_slug]) }}">&raquo; {{$sub_cat->category_name}}</a> </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endsection
