@extends('layouts.app')
@section('title')
    @if (!empty($title))
        {{ $title }} |
    @endif @parent
@endsection

@section('content')
    @if (get_option('enable_monetize') == 1)
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! get_option('monetize_code_above_categories') !!}
                </div>
            </div>
        </div>
    @endif

    @if ($topCategories->count())
        <div class="home-category">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="front-ads-head">
                            <h2>@lang('app.categories')</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row equal">
                    @foreach ($topCategories as $top_cat)
                        <div class="col-md-3">
                            <div class="home-cat-box">
                                <div class="home-cat-box-title">
                                    <h3> <a href="{{ Route('categoryparent', ['category' => $top_cat->slug_path]) }}">
                                            {{ $top_cat->category_name }}
                                            <span class="count">({{$top_cat->ad_count}})</span>
                                        </a>
                                    </h3>
                                    @if (count($top_cat->children) > 0)
                                        @foreach ($top_cat->children as $child)
                                            {{ $child->title }}
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if (get_option('enable_monetize') == 1)
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! get_option('monetize_code_below_categories') !!}
                </div>
            </div>
        </div>
    @endif

    @if ($premium_ads->count())
        <div id="premium-ads-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="front-ads-head">
                            <h2>@lang('app.new_premium_ads')</h2>
                        </div>
                    </div>
                </div>
                <div class="row related-products">
                    @foreach ($premium_ads as $ad)
                        <div class="col-md-3">
                            <x-postcard :ad="$ad" :favorites="$favorites" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="no-ads-wrap">
                        <h2><i class="fa fa-frown-o"></i> @lang('app.no_premium_ads_country') </h2>

                        @if (env('APP_DEMO') == true)
                            <h4>Seems you are checking the demo version, you can check ads preview by switching country to
                                <a href="{{ route('set_country', 'US') }}"><img
                                        src="{{ asset('assets/flags/16/us.png') }}" /> United States </a>
                            </h4>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($regular_ads->count())
        <div id="regular-ads-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="front-ads-head">
                            <h2>@lang('app.new_regular_ads')</h2>
                        </div>
                    </div>
                </div>
                <div class="row related-products">
                    @foreach ($regular_ads as $ad)
                        <div class="col-md-3">
                            <x-postcard :ad="$ad" :favorites="$favorites" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="no-ads-wrap">
                        <h2><i class="fa fa-frown-o"></i> @lang('app.no_regular_ads_country') </h2>

                        @if (env('APP_DEMO') == true)
                            <h4>Seems you are checking the demo version, you can check ads preview by switching country to
                                <a href="{{ route('set_country', 'US') }}"><img
                                        src="{{ asset('assets/flags/16/us.png') }}" /> United States </a>
                            </h4>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- <script src="{{ asset('assets/plugins/fotorama-4.6.4/fotorama.js') }}"></script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const elements = document.querySelectorAll(".related-products .overlay");
            const len = elements.length;
            for (let i = 0; i < len; i++) {
                const item = elements.item(i);
                const ii = Number(item.getAttribute("data-id"));
                const images = item.querySelectorAll(".post-thumbnail .fotorama img");
                const sliderItem = {
                    length: images.length,
                    index: 0
                };

                item.addEventListener("mouseenter", (e) => {
                    item.classList.add("hover");
                })
                item.addEventListener("mouseleave", (e) => {
                    item.classList.remove("hover");
                });

                const init = () => {
                    for (let j = 0; j < sliderItem.length; j++) {
                        const id = `card-image-${ii}-${j}`;
                        if (sliderItem.index == j) {
                            document.getElementById(id).classList.add('active');
                        } else {
                            document.getElementById(id).classList.remove('active');
                        }

                    }
                }

                const move = (d) => {
                    sliderItem.index += d;
                    if (sliderItem.index >= sliderItem.length) sliderItem.index = 0;
                    if (sliderItem.index < 0) sliderItem.index = sliderItem.length - 1;
                    init();
                }

                const leftButton = item.querySelector(".slider-button-left");
                const rightButton = item.querySelector(".slider-button-right");

                leftButton.addEventListener("click", function(e) {
                    move(-1);
                })
                rightButton.addEventListener("click", function(e) {
                    move(1);
                })

                init();
            }
        })
        $(document).ready(function(e) {
            const classActive = `fa-heart`;
            const classInactive = `fa-heart-o`;
            $("button[type=toggle-favorite]").click(async function(e) {
                const adid = Number($(this).attr("data-id"));
                const iElement = this.getElementsByTagName("i")[0];

                const enableButton = (status = true) => {
                    if (status) $(this).removeAttr("disabled")
                    else $(this).attr("disabled", true)
                }

                let url = `{{ route('toggle-favorite') }}`;
                enableButton(false);
                const req = $.ajax({
                    url: '{{ route('toggle-favorite') }}',
                    type: "PUT",
                    async: true,
                    data: {
                        id: adid,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.status) {
                            iElement?.classList?.add(classActive);
                            iElement?.classList?.remove(classInactive);
                        } else {
                            iElement?.classList?.add(classInactive);
                            iElement?.classList?.remove(classActive);
                        }
                        enableButton();
                    },
                    error() {
                        alert("error");
                        enableButton(false);
                    }
                });
            })

        })
    </script>
    <style>
        .overlay {
            position: relative;
        }

        .slider-button-left,
        .slider-button-right {
            display: none;
            cursor: pointer;
            top: 70px;
            color: white;
            background-color: #0000007a;
        }

        .slider-button-left i,
        .slider-button-right i {
            font-size: 25px
        }

        .hover .slider-button-left {
            position: absolute;
            display: block;
            left: 0px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            padding: 4px 10px 4px 5px;
        }

        /* .overlay.hover  */
        .hover .slider-button-right {
            position: absolute;
            display: block;
            right: 0px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            padding: 4px 5px 4px 10px;
        }

        .postcard_img {
            opacity: 0;
            position: absolute;
            top: 0;
        }

        .postcard_img.active {
            opacity: 1;
            transition: ease all 0.3s;
        }
    </style>

@endsection
