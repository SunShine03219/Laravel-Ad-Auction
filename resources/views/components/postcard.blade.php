@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/fotorama-4.6.4/fotorama.css') }}">
@endsection

@if($ad->prom_glow)
    <div class="post-card overlay" id="post-card-{{ $ad->id }}" data-id="{{ $ad->id }}">
@else
    <div class="post-card no-glow overlay" id="post-card-{{ $ad->id }}" data-id="{{ $ad->id }}">
@endif

@auth
{{-- <h1>{{ Auth::user()->id }}</h1> --}}
@else
{{-- <h2>Right</h2> --}}
@endauth
        <div class="post-thumbnail">
        <a href="{{ route('single_ad', [$ad->id]) }}">
            <div class="fotorama" data-nav="thumbs" data-allowfullscreen="true" data-width="10%">
                <?php $index = 0; ?>
                @foreach ($ad->media_img as $img)
                    <img class="postcard_img" itemprop="image" src="{{ media_url($img, true) }}"
                        alt="{{ $ad->title }}" id="card-image-{{ $ad->id }}-{{ $index }}">
                    <?php $index++; ?>
                @endforeach
            </div>
            {{-- <img itemprop="image"  src="{{ media_url($ad->feature_img) }}" class="img-responsive" alt="{{ $ad->title }}"> --}}
            {{-- <span class="modern-img-indicator">
                    @if (!empty($ad->video_url))
                    <i class="fa fa-file-video-o"></i>
                    @else
                    <i class="fa fa-file-image-o"> {{ $ad->media_img->count() }}</i>
                    @endif 
                </span> --}}
        </a>
        @auth      
        <button type="toggle-favorite" data-id={{$ad->id}} class="post-card-tri-btn post-card-favorite arrow-left">
            @if(isset($ad->fid))
                <i class="fa fa-heart"></i>
            @else
                <i class="fa fa-heart-o"></i>
            @endif
        </button>
        @else            
            <a href="{{route('login')}}" data-id={{$ad->id}} class="post-card-favorite arrow-left">
                <i class="fa fa-heart-o"></i>
            </a>
        @endauth
        {{-- @if ($ad->price_plan == 'premium')
            <div class="post-card-premium" data-toggle="tooltip" title="@lang('app.premium_ad')">
                {!! $ad->premium_icon() !!}
            </div>
            @endif --}}
        {{-- <div class="arrow-left"></div> --}}
    </div>
    <a href="{{ route('single_ad', [$ad->id, $ad->slug]) }}">
        <div class="caption">
            <div class="post-card-caption-title">
                @if ($ad->sub_category)
                    <i class="fa fa-map-marker"></i>
                    <span class="price text-muted">
                        {{ $ad->sub_category->category_name }} </span>
                @endif
                <div class="countdown" data-expire-date="{{ $ad->expired_at }}"></div>
            </div>
    
            <div class="post-card-category">
                @if ($ad->prom_bold)
                    <span class="post-card-title bold"
                        title="{{ $ad->title }}">
                        {{ str_limit($ad->title, 40) }}
                    </span>
                @else
                    <span class="post-card-title"
                        title="{{ $ad->title }}">
                        {{ str_limit($ad->title, 40) }}
                    </span>
                @endif
            </div>
    
            <div class="location">
                @if ($ad->city)
                <span class="text-muted">
                    {{ $ad->city->city_name }} </span>
                @endif
                <span style="margin-bottom: 20px; visibility:hidden;">-</span>
            </div>
    
            <div class="post-card-footer">
                <div class="post-card-price-title">
                    @lang('app.no_reserve')
                    <span class="float-right">@lang('app.buy_now')</span>
                </div>
                <div class="post-card-price">
                    {!! themeqx_price($ad->current_bid()) !!}
                    <span class="float-right">{!! themeqx_price($ad->price) !!}</span>
                </div>
            </div>
        </div>

    </a>
    <div class="slider-button-left">
        <i class="fa fa-angle-left"></i>
    </div>
    <div class="slider-button-right">
        <i class="fa fa-angle-right"></i>
    </div>
</div>
