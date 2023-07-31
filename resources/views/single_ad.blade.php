@extends('layouts.app')
@section('title')
    @if (!empty($title))
        {{ strip_tags($title) }} |
    @endif @parent
@endsection

@section('social-meta')
    <meta property="og:title" content="{{ safe_output($ad->title) }}">
    <meta property="og:description"
        content="{{ substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($ad->description))), 0, 160) }}">
    @if ($ad->media_img->first())
        <meta property="og:image" content="{{ media_url($ad->media_img->first(), true) }}">
    @else
        <meta property="og:image" content="{{ asset('uploads/placeholder.png') }}">
    @endif
    <meta property="og:url" content="{{ route('single_ad', [$ad->id, $ad->slug]) }}">
    <meta name="twitter:card" content="summary_large_image">
    <!--  Non-Essential, But Recommended -->
    <meta name="og:site_name" content="{{ get_option('site_name') }}">
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/fotorama-4.6.4/fotorama.css') }}">
@endsection

@section('content')

    {{-- <div class="page-header search-page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ safe_output($ad->title) }}</h2>

                </div>
            </div>
        </div>
    </div> --}}


    {{-- @if (get_option('enable_monetize') == 1)
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! get_option('monetize_code_below_ad_title') !!}
                </div>
            </div>
        </div>
    @endif --}}

    <div class="single-auction-wrap">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="breadcrumb">
                        <a href="{{ route('home') }}" class="">Home</a> /

                        <a href="{{ route('search', [$ad->country->country_code]) }}" class="">
                            {{ $ad->country->country_code }}</a>

                        @if ($ad->category)
                            /&nbsp;<a
                                href="{{ route('search', [$ad->country->country_code, 'category' => 'cat-' . $ad->category->id . '-' . $ad->category->category_slug]) }}"
                                class=""> {{ $ad->category->category_name }} </a>
                        @endif
                        @if ($ad->sub_category)
                            /&nbsp;<a
                                href="{{ route('search', [$ad->country->country_code, 'category' => 'cat-' . $ad->sub_category->id . '-' . $ad->sub_category->category_slug]) }}"
                                class=""> {{ $ad->sub_category->category_name }} </a>
                        @endif

                        /&nbsp;<a href="{{ route('single_ad', [$ad->id, $ad->slug]) }}"
                            class="">{{ safe_output($ad->title) }}</a>

                    </div>
                </div>
                <div class="col-sm-8 col-xs-12">

                    @include('admin.flash_msg')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    <div class="auction-img-video-wrap">
                        @if (!$ad->is_published())
                            <div class="alert alert-warning"><i class="fa fa-warning"></i> @lang('app.ad_not_published_warning')</div>
                        @endif
                        @if (!empty($ad->video_url))
                            <?php
                            $video_url = safe_output($ad->video_url);
                            if (strpos($video_url, 'youtube') > 0) {
                                preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
                                if (!empty($matches[1])) {
                                    echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe></div>';
                                }
                            } elseif (strpos($video_url, 'vimeo') > 0) {
                                if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $video_url, $regs)) {
                                    if (!empty($regs[3])) {
                                        echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://player.vimeo.com/video/' . $regs[3] . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
                                    }
                                }
                            }
                            ?>
                        @else
                            <div class="ads-gallery">
                                <div class="fotorama" data-nav="thumbs" data-allowfullscreen="true" data-width="100%">
                                    @foreach ($ad->media_img as $img)
                                        <img src="{{ media_url($img, true) }}" alt="{{ $ad->title }}">
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>


                    @if (get_option('enable_monetize') == 1)
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! get_option('monetize_code_below_ad_image') !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="ads-detail">
                        @lang('app.description')</h4>
                        {!! nl2br(safe_output($ad->description)) !!}
                    </div>


                    @if (get_option('enable_monetize') == 1)
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! get_option('monetize_code_below_ad_description') !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($ad->category_type == 'auction')
                        <hr />
                        <div id="bid_history">
                            <h2>@lang('app.bid_history')</h2>

                            @if ($ad->bids->count())
                                <table class="table table-striped">
                                    <tr>
                                        <th>@lang('app.bidder')</th>
                                        <th>@lang('app.bid_amount')</th>
                                        <th>@lang('app.date_time')</th>
                                    </tr>
                                    @foreach ($ad->bids as $bid)
                                        <tr>
                                            <td>@lang('app.bidder') #{{ $bid->user_id }}</td>
                                            <td>{!! themeqx_price($bid->bid_amount) !!}</td>
                                            <td>{{ $bid->posting_datetime() }}</td>
                                        </tr>
                                    @endforeach

                                </table>
                            @else
                                <p>@lang('app.there_is_no_bids')</p>
                            @endif
                        </div>
                    @endif

                    @if (get_option('enable_fb_comments') == 1)
                        <hr />
                        <div class="fb-comments" data-href="{{ route('single_ad', [$ad->id, $ad->slug]) }}"
                            data-width="100%"></div>
                    @endif

                    @if (get_option('enable_comments') == 1)
                        <hr />
                        @php    $comments_count = 0;                      
                        $comments = \App\Models\Comment::approved()
                                ->parent()
                                ->whereAdId($ad->id)
                                ->with('childs_approved')
                                ->orderBy('id', 'desc')
                                ->get();
                            $comments_count = \App\Models\Comment::approved()
                                ->whereAdId($ad->id)
                                ->count();
                        @endphp 
                        <div class="comments-container">
                            @if ($comments_count < 1)
                                <h2>@lang('app.no_comment_found')</h2>
                            @elseif($comments_count == 1)
                                <h2>{{ $comments_count }} @lang('app.comment_found')</h2>
                            @elseif($comments_count > 1)
                                <h2>{{ $comments_count }} @lang('app.comments_found')</h2>
                            @endif

                            <div class="post-comments-form">

                                <form action="{{ route('post_comments', $ad->id) }}" class="form-horizontal" method="post"
                                    enctype="multipart/form-data"> @csrf

                                    @if (!auth()->check())
                                        <div class="form-group {{ $errors->has('author_name') ? 'has-error' : '' }}">
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="author_name"
                                                    value="@if (auth()->check()) {{ auth()->user()->name }}@else{{ old('author_name') }} @endif"
                                                    name="author_name" placeholder="@lang('app.author_name')">
                                                {!! $errors->has('author_name') ? '<p class="help-block">' . $errors->first('author_name') . '</p>' : '' !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->has('author_email') ? 'has-error' : '' }}">
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="author_email"
                                                    value="@if (auth()->check()) {{ auth()->user()->email }}@else{{ old('author_email') }} @endif"
                                                    name="author_email" placeholder="@lang('app.author_email')">
                                                {!! $errors->has('author_email') ? '<p class="help-block">' . $errors->first('author_email') . '</p>' : '' !!}
                                                <p class="text-info">@lang('app.email_secured')</p>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="comment" rows="8" placeholder="@lang('app.write_your_comment')"></textarea>
                                            {!! $errors->has('comment') ? '<p class="help-block">' . $errors->first('comment') . '</p>' : '' !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-8">
                                            <input type="hidden" value="" class="comment_id" name="comment_id">
                                            <button type="submit" class="btn btn-success" name="post_comment"><i
                                                    class="fa fa-pencil-square"></i> @lang('app.post_comment')
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @if ($comments->count())
                                <ul id="comments-list" class="comments-list">

                                    @foreach ($comments as $comment)
                                        <li id="comment-{{ $comment->id }}">
                                            <div class="comment-main-level">
                                                <!-- Avatar -->
                                                <div class="comment-avatar">
                                                    @if ($comment->user_id)
                                                        <img src="{{ $comment->author->get_gravatar() }}"
                                                            alt="{{ $comment->author_name }}">
                                                    @else
                                                        <img src="{{ avatar_by_email($comment->author_email) }}"
                                                            alt="{{ $comment->author_name }}">
                                                    @endif
                                                </div>
                                                <!-- Contenedor del Comentario -->
                                                <div class="comment-box" data-comment-id="{{ $comment->id }}">
                                                    <div class="comment-head">
                                                        <h6 class="comment-name by-author">{{ $comment->author_name }}
                                                        </h6>
                                                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                        <i class="fa fa-reply"></i>
                                                    </div>
                                                    <div class="comment-content">
                                                        {!! safe_output(nl2br($comment->comment)) !!}
                                                    </div>

                                                    <div class="reply_form_box" style="display: none;"></div>
                                                </div>
                                            </div>

                                            @if ($comment->childs_approved)
                                                @foreach ($comment->childs_approved as $childComment)
                                                    <!-- Respuestas de los comentarios -->
                                                    <ul class="comments-list reply-list">
                                                        <li id="comment-{{ $childComment->id }}">
                                                            <!-- Avatar -->
                                                            <div class="comment-avatar">
                                                                @if ($childComment->user_id)
                                                                    <img src="{{ $childComment->author->get_gravatar() }}"
                                                                        alt="{{ $childComment->author_name }}">
                                                                @else
                                                                    <img src="{{ avatar_by_email($childComment->author_email) }}"
                                                                        alt="{{ $childComment->author_name }}">
                                                                @endif
                                                            </div>
                                                            <!-- Contenedor del Comentario -->
                                                            <div class="comment-box"
                                                                data-comment-id="{{ $comment->id }}">
                                                                <div class="comment-head">
                                                                    <h6 class="comment-name by-author">
                                                                        {{ $childComment->author_name }}</h6>
                                                                    <span>{{ $childComment->created_at->diffForHumans() }}</span>
                                                                    <i class="fa fa-reply"></i>
                                                                </div>
                                                                <div class="comment-content">
                                                                    {!! safe_output(nl2br($childComment->comment)) !!}
                                                                </div>
                                                                <div class="reply_form_box" style="display: none;"></div>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                @endforeach
                                            @endif
                                        </li>
                                    @endforeach


                                </ul>
                            @else
                            @endif


                        </div>
                    @endif

                </div>

                <div class="col-sm-4 col-xs-12">
                    <div class="sidebar-widget">

                        <h2 class="ad-title">{{ safe_output($ad->title) }}</h2>

                        <div class="ad-duration">
                            <h3>Still in stock till: Mon 5th Jun, 8:10am</h3>
                            <span>3 days, 11 hours</span>
                        </div>

                        <div class="watchlist-group">
                            <button class="btn add-to-watchlist-btn"> <img
                                    src="{{ asset('assets/img/icons/heart-outlined.png') }}" /> Add to Watchlist</button>
                            <span class="">176 others watchlisted</span>
                        </div>

                        @if ($ad->category_type == 'auction')
                            <div class="widget">
                                <h3>{!! themeqx_price($ad->current_bid()) !!}</h3>

                                <button class="btn pay-btn">Pay {!! themeqx_price($ad->current_bid()) !!}</button>

                                <div class="reserve">
                                    <p>Reserve met</p>
                                    <span>69 payment so far - <a href="#">view history</a></span>
                                </div>
                                <div class="widget-footer">
                                    <img src="{{ asset('assets/img/icons/delivery-truck.png') }}" alt="delivery">
                                    Shipping <span>from $11.99</span>
                                </div>
                            </div>
                        @endif


                        @if (get_option('enable_monetize') == 1)
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! get_option('monetize_code_above_general_info') !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="widget">
                            <div class="widget-heading">Seller information</div>
                            <div class="seller-info">
                                <img src="{{ asset('assets/img/auction-kings.png') }}" alt="">
                                <h4 class="title">ShibelVogue-SEA-COD</h4>
                                <div class="followers">
                                    <span>1790</span>
                                    followers
                                </div>
                                <p>94% Seller Score</p>
                                <p>94% Positive feedback</p>
                            </div>
                            <div class="widget-heading">Seller Performance</div>
                            <div class="performance">
                                <ul>
                                    <li><img src="{{ asset('assets/img/seller-star.png') }}" /> Order fulfillment rate:
                                        Excelent</li>
                                    <li><img src="{{ asset('assets/img/seller-star.png') }}" /> Quality Score: Excelent
                                    </li>
                                    <li><img src="{{ asset('assets/img/seller-star.png') }}" /> Customer Rating: Good
                                    </li>
                                </ul>
                                <p>Member Since <span>Sunday, 8 September 2009</span></p>
                                <p><img src="{{asset('assets/img/icons/location.png')}}" alt="location"> Whakatane</p>
                                <button class="btn btn-store">View Store</button>
                                <a href="#">Read our safe buying advice</a>
                            </div>
                        </div>

                        @if (get_option('enable_monetize') == 1)
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! get_option('monetize_code_below_general_info') !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="widget">

                            {{-- <h3>@lang('app.seller_info')</h3> --}}
                            @if (!empty($ad->user))
                                <div class="sidebar-user-info">
                                    <div class="ad-single-user-avatar">
                                        <img src="{{ $ad->user->get_gravatar() }}" class="img-circle img-responsive" />
                                    </div>

                                    <div class="ad-single-user-info">
                                        <h5>{{ $ad->user->name }}</h5>
                                        @php $user_address = $ad->user->get_address(); @endphp
                                        @if ($user_address)
                                            <p class="text-muted"><i class="fa fa-map-marker"></i>
                                                {!! $user_address !!}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="sidebar-user-link">

                                @if (!$ad->category_type == 'jobs')
                                    <button class="btn btn-block" id="onClickShowPhone">
                                        <strong> <span id="ShowPhoneWrap"></span> </strong> <br />
                                        <span class="text-muted">@lang('app.click_to_show_phone_number')</span>
                                    </button>
                                @endif

                                <ul class="ad-action-list">
                                    @if (!empty($ad->user))
                                        <li><a href="{{ route('ads_by_user', ['user_id' => $ad->user_id]) }}"><i
                                                    class="fa fa-user"></i> @lang('app.view_all_ad_of_this') @if ($ad->category_type == 'jobs')
                                                    @lang('app.employer')
                                                @else
                                                    @lang('app.seller')
                                                @endif </a></li>
                                    @endif

                                    <li>
                                        <a href="javascript:;" id="save_as_favorite" data-slug="{{ $ad->slug }}">
                                            @if (!$ad->is_my_favorite())
                                                <i class="fa fa-star-o"></i> @lang('app.save_ad_as_favorite')
                                            @else
                                                <i class="fa fa-star"></i> @lang('app.remove_from_favorite')
                                            @endif
                                        </a>
                                    </li>

                                    @if (!$ad->category_type == 'jobs')
                                        @if (!empty($ad->user) && $ad->user->email)
                                            <li><a href="#" data-toggle="modal" data-target="#replyByEmail"><i
                                                        class="fa fa-envelope-o"></i> @lang('app.reply_by_email')
                                                </a></li>
                                        @endif
                                    @endif

                                    <li><a href="#" data-toggle="modal" data-target="#reportAdModal"><i
                                                class="fa fa-ban"></i> @lang('app.report_this_ad')</a></li>
                                </ul>

                            </div>

                        </div>

                        @if (get_option('enable_monetize') == 1)
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! get_option('monetize_code_below_seller_info') !!}
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>

                </div>
            </div>
        </div>

    </div>


    <div class="footer-features">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2>@lang('app.sell_your_items_through')</h2>
                    <p>@lang('app.thousands_of_people_selling')</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <div class="icon-text-feature">
                        <i class="fa fa-check-circle-o"></i>
                        @lang('app.trusted_buyers')
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="icon-text-feature">
                        <i class="fa fa-check-circle-o"></i>
                        @lang('app.swift_and_secure')
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="icon-text-feature">
                        <i class="fa fa-check-circle-o"></i>
                        @lang('app.spam_free')
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="icon-text-feature">
                        <i class="fa fa-check-circle-o"></i>
                        @lang('app.sell_your_items_quickly')
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <a href="{{ route('category') }}" class="btn btn-warning btn-lg"><i class="fa fa-search"></i>
                        @lang('app.browse_ads')</a>
                    <a href="{{ route('create_ad') }}" class="btn btn-warning btn-lg"><i class="fa fa-save"></i>
                        @lang('app.post_an_ad')</a>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="reportAdModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('app.report_ad_title')</h4>
                </div>
                <div class="modal-body">

                    <p>@lang('app.report_ad_description')</p>

                    <form>

                        <div class="form-group">
                            <label class="control-label">@lang('app.reason'):</label>
                            <select class="form-control" name="reason">
                                <option value="">@lang('app.select_a_reason')</option>
                                <option value="unavailable">@lang('app.item_sold_unavailable')</option>
                                <option value="fraud">@lang('app.fraud')</option>
                                <option value="duplicate">@lang('app.duplicate')</option>
                                <option value="spam">@lang('app.spam')</option>
                                <option value="wrong_category">@lang('app.wrong_category')</option>
                                <option value="offensive">@lang('app.offensive')</option>
                                <option value="other">@lang('app.other')</option>
                            </select>

                            <div id="reason_info"></div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <div id="email_info"></div>

                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">@lang('app.message'):</label>
                            <textarea class="form-control" id="message" name="message"></textarea>
                            <div id="message_info"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn btn-primary" id="report_ad">@lang('app.report_ad')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="replyByEmail" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>

                <form action="" id="replyByEmailForm" method="post" enctype="multipart/form-data"> @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">@lang('app.name'):</label>
                            <input type="text" class="form-control" id="name" name="name"
                                data-validation="required">
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">@lang('app.email'):</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>

                        <div class="form-group">
                            <label for="phone_number" class="control-label">@lang('app.phone_number'):</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number">
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="control-label">@lang('app.message'):</label>
                            <textarea class="form-control" id="message" name="message"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
                        <button type="submit" class="btn btn-primary"
                            id="reply_by_email_btn">@lang('app.send_email')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    @if (get_option('enable_fb_comments') == 1)
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    @endif

    <script src="{{ asset('assets/plugins/fotorama-4.6.4/fotorama.js') }}"></script>
    <script src="{{ asset('assets/plugins/SocialShare/SocialShare.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-validator/form-validator.min.js') }}"></script>

    <script>
        $('.share').ShareLink({
            title: '{{ $ad->title }}', // title for share message
            text: '{{ substr(trim(preg_replace('/\s\s+/', ' ', strip_tags($ad->description))), 0, 160) }}', // text for share message

            @if ($ad->media_img->first())
                image: '{{ media_url($ad->media_img->first(), true) }}', // optional image for share message (not for all networks)
            @else
                image: '{{ asset('uploads/placeholder.png') }}', // optional image for share message (not for all networks)
            @endif
            url: '{{ route('single_ad', [$ad->id, $ad->slug]) }}', // link on shared page
            class_prefix: 's_', // optional class prefix for share elements (buttons or links or everything), default: 's_'
            width: 640, // optional popup initial width
            height: 480 // optional popup initial height
        })
    </script>
    <script>
        $.validate();
    </script>

    <script>
        $(function() {
            $('#onClickShowPhone').click(function() {
                $('#ShowPhoneWrap').html('<i class="fa fa-phone"></i> {{ $ad->seller_phone }}');
            });

            $('#save_as_favorite').click(function() {
                var selector = $(this);
                var slug = selector.data('slug');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('save_ad_as_favorite') }}',
                    data: {
                        slug: slug,
                        action: 'add',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            selector.html(data.msg);
                        } else {
                            if (data.redirect_url) {
                                location.href = data.redirect_url;
                            }
                        }
                    }
                });
            });

            $('button#report_ad').click(function() {
                var reason = $('[name="reason"]').val();
                var email = $('[name="email"]').val();
                var message = $('[name="message"]').val();
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                var error = 0;
                if (reason.length < 1) {
                    $('#reason_info').html('<p class="text-danger">Reason required</p>');
                    error++;
                } else {
                    $('#reason_info').html('');
                }
                if (email.length < 1) {
                    $('#email_info').html('<p class="text-danger">Email required</p>');
                    error++;
                } else {
                    if (!regex.test(email)) {
                        $('#email_info').html('<p class="text-danger">Valid email required</p>');
                        error++;
                    } else {
                        $('#email_info').html('');
                    }
                }
                if (message.length < 1) {
                    $('#message_info').html('<p class="text-danger">Message required</p>');
                    error++;
                } else {
                    $('#message_info').html('');
                }

                if (error < 1) {
                    $('#loadingOverlay').show();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('report_ads_pos') }}',
                        data: {
                            reason: reason,
                            email: email,
                            message: message,
                            slug: '{{ $ad->slug }}',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.status == 1) {
                                toastr.success(data.msg, '@lang('app.success')', toastr_options);
                            } else {
                                toastr.error(data.msg, '@lang('app.error')', toastr_options);
                            }
                            $('#reportAdModal').modal('hide');
                            $('#loadingOverlay').hide();
                        }
                    });
                }
            });

            $('#replyByEmailForm').submit(function(e) {
                e.preventDefault();
                var reply_email_form_data = $(this).serialize();

                $('#loadingOverlay').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('reply_by_email_post') }}',
                    data: reply_email_form_data,
                    success: function(data) {
                        if (data.status == 1) {
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        } else {
                            toastr.error(data.msg, '@lang('app.error')', toastr_options);
                        }
                        $('#replyByEmail').modal('hide');
                        $('#loadingOverlay').hide();
                    }
                });
            });

            $(document).on('click', '.comments-list .fa-reply', function(e) {
                e.preventDefault();

                var comment_id = $(this).closest('.comment-box').attr('data-comment-id');
                var reply_form = $('.post-comments-form').html();
                reply_form +=
                    '<a href="javascript:;" class="text-danger reply_form_remove"><i class="fa fa-times"> </a>';

                //reply_form_box
                $(this).closest('.comment-box').find('.reply_form_box').html(reply_form).show().find(
                    '.comment_id').val(comment_id);

            });

            $(document).on('click', '.reply_form_remove', function(e) {
                e.preventDefault();
                $(this).closest('form').remove();
                $(this).closest('.reply_form_box').hide();
            });

        });
    </script>
@endsection
