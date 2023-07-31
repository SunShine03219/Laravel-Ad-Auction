@extends('layouts.app')
@section('title')
    @if( ! empty($title))
        {{ $title }} |
    @endif @parent
@endsection

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div id="post-new-ad">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    @if( ! \Auth::check())
                        <div class="alert alert-info no-login-info">
                            <p><i class="fa fa-info-circle"></i> @lang('app.no_login_info')</p>
                        </div>
                    @endif

                    @include('admin.flash_msg')

                    <form action="{{route('store.new.post')}}" id="adsPostForm" class="form-horizontal" method="post"
                          enctype="multipart/form-data"> @csrf

                        <legend><span class="ad_text"> @lang('app.ad') </span> @lang('app.info')</legend>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group  {{ $errors->has('category')? 'has-error':'' }}">
                            <label for="category_name" class="col-sm-4 control-label">@lang('app.category')</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="category">
                                    <option value="">@lang('app.select_a_category')</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ old('category') == $category->id ? 'selected': '' }} data-category-type="{{$category->category_type}}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('category')? '<p class="help-block">'.$errors->first('category').'</p>':'' !!}
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('ad_title')? 'has-error':'' }}">
                            <label for="ad_title" class="col-sm-4 control-label"> <span
                                        class="ad_text"> @lang('app.ad') </span> @lang('app.title')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="ad_title" value="{{ old('ad_title') }}"
                                       name="ad_title" placeholder="@lang('app.ad_title')">
                                {!! $errors->has('ad_title')? '<p class="help-block">'.$errors->first('ad_title').'</p>':'' !!}
                                <p class="text-info"> @lang('app.great_title_info')</p>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('ad_description')? 'has-error':'' }}">
                            <label class="col-sm-4 control-label"><span
                                        class="ad_text"> @lang('app.ad') </span> @lang('app.description')</label>
                            <div class="col-sm-8">
                                <textarea name="ad_description" class="form-control" id="content_editor"
                                          rows="8">{{ old('ad_description') }}</textarea>
                                {!! $errors->has('ad_description')? '<p class="help-block">'.$errors->first('ad_description').'</p>':'' !!}
                                <p class="text-info"> @lang('app.ad_description_info_text')</p>
                            </div>
                        </div>


                        <div class="form-group  {{ $errors->has('price')? 'has-error':'' }}">
                            <label for="price" class="col-md-4 control-label"> <span
                                        class="price_text">@lang('app.starting_price')</span> </label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">{{ get_option('currency_sign') }}</span>
                                    <input type="text" placeholder="@lang('app.ex_price')" class="form-control"
                                           name="price" id="price" value="{{ old('price') }}">
                                </div>
                            </div>

                            <div class="col-sm-8 col-md-offset-4">
                                {!! $errors->has('price')? '<p class="help-block">'.$errors->first('price').'</p>':'' !!}
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('bid_deadline')? 'has-error':'' }}">
                            <label for="bid_deadline" class="col-sm-4 control-label"> @lang('app.bid_deadline')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datetimepicker-input" id="datetimepicker"
                                       value="{{ old('bid_deadline') }}" name="bid_deadline"
                                       placeholder="@lang('app.bid_deadline')">
                                {!! $errors->has('bid_deadline')? '<p class="help-block">'.$errors->first('bid_deadline').'</p>':'' !!}
                            </div>
                        </div>

                        <legend>@lang('app.image')</legend>

                        <div class="form-group {{ $errors->has('images')? 'has-error':'' }}">
                            <div class="col-sm-12">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <div class="upload-images-input-wrap">
                                        <input type="file" name="images[]" class="form-control"/>
                                        <input type="file" name="images[]" class="form-control"/>
                                    </div>

                                    <div class="image-ad-more-wrap">
                                        <a href="javascript:;" class="image-add-more"><i
                                                    class="fa fa-plus-circle"></i> @lang('app.add_more')</a>
                                    </div>
                                </div>
                                {!! $errors->has('images')? '<p class="help-block">'.$errors->first('images').'</p>':'' !!}
                            </div>
                        </div>

                        <legend>@lang('app.video')</legend>

                        <div class="form-group {{ $errors->has('video_url')? 'has-error':'' }}">
                            <label for="video_url" class="col-sm-4 control-label">@lang('app.video_url')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="video_url" value="{{ old('video_url') }}"
                                       name="video_url" placeholder="@lang('app.video_url')">
                                {!! $errors->has('video_url')? '<p class="help-block">'.$errors->first('video_url').'</p>':'' !!}
                                <p class="help-block">@lang('app.video_url_help')</p>
                                <p class="text-info">@lang('app.video_url_help_for_modern_theme')</p>
                            </div>
                        </div>


                        <legend>@lang('app.location_info')</legend>

                        <div class="form-group  {{ $errors->has('country')? 'has-error':'' }}">
                            <label class="col-sm-4 control-label">@lang('app.country')</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="country">
                                    <option value="">@lang('app.select_a_country')</option>

                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' :'' }}>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->has('country')? '<p class="help-block">'.$errors->first('country').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('state')? 'has-error':'' }}">
                            <label for="state_select" class="col-sm-4 control-label">@lang('app.state')</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="state_select" name="state">
                                    @if($previous_states->count() > 0)
                                        @foreach($previous_states as $state)
                                            <option value="{{ $state->id }}" {{ old('state') == $state->id ? 'selected' :'' }}>{{ $state->state_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="text-info">
                                    <span id="state_loader" style="display: none;"><i class="fa fa-spin fa-spinner"></i> </span>
                                </p>
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('city')? 'has-error':'' }}">
                            <label for="city_select" class="col-sm-4 control-label">@lang('app.city')</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="city_select" name="city">
                                    @if($previous_cities->count() > 0)
                                        @foreach($previous_cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city') == $city->id ? 'selected':'' }}>{{ $city->city_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="text-info">
                                    <span id="city_loader" style="display: none;"><i class="fa fa-spin fa-spinner"></i> </span>
                                </p>
                            </div>
                        </div>

                        <legend><span class="seller_text"> @lang('app.seller') </span> @lang('app.info')</legend>

                        <div class="form-group {{ $errors->has('seller_name')? 'has-error':'' }}">
                            <label for="seller_name" class="col-sm-4 control-label"> <span
                                        class="seller_text"> @lang('app.seller') </span> @lang('app.name')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="seller_name"
                                       value="{{ old('seller_name')? old('seller_name') : (Auth::check() ? $lUser->name : '' )  }}"
                                       name="seller_name" placeholder="@lang('app.name')">
                                {!! $errors->has('seller_name')? '<p class="help-block">'.$errors->first('seller_name').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('seller_email')? 'has-error':'' }}">
                            <label for="seller_email" class="col-sm-4 control-label"> <span
                                        class="seller_text"> @lang('app.seller') </span> @lang('app.email')</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="seller_email"
                                       value="{{ old('seller_email')? old('seller_email') : (Auth::check() ? $lUser->email : '' ) }}"
                                       name="seller_email" placeholder="@lang('app.email')">
                                {!! $errors->has('seller_email')? '<p class="help-block">'.$errors->first('seller_email').'</p>':'' !!}
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('seller_phone')? 'has-error':'' }}">
                            <label for="seller_phone" class="col-sm-4 control-label"> <span
                                        class="seller_text"> @lang('app.seller') </span> @lang('app.phone')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="seller_phone"
                                       value="{{ old('seller_phone') ? old('seller_phone') : (Auth::check() ? $lUser->phone : '' ) }}"
                                       name="seller_phone" placeholder="@lang('app.phone')">
                                {!! $errors->has('seller_phone')? '<p class="help-block">'.$errors->first('seller_phone').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('address')? 'has-error':'' }}">
                            <label for="address" class="col-sm-4 control-label">@lang('app.address')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="address"
                                       value="{{ old('address')? old('address') : (Auth::check() ? $lUser->address : '' ) }}"
                                       name="address" placeholder="@lang('app.address')">
                                {!! $errors->has('address')? '<p class="help-block">'.$errors->first('address').'</p>':'' !!}
                                <p class="text-info">@lang('app.address_line_help_text')</p>
                            </div>
                        </div>

                        @if(get_option('ads_price_plan') != 'all_ads_free')
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">@lang('app.payment_info')</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="form-group {{ $errors->has('price_plan')? 'has-error':'' }}">
                                        <label for="price_plan"
                                               class="col-sm-4 control-label">@lang('app.price_plan')</label>
                                        <div class="col-sm-8">

                                            <div class="price_input_group">

                                                <label>
                                                    <input type="radio" value="regular" name="price_plan"
                                                           data-price="{{ get_ads_price() }}"
                                                           checked="checked"/>@lang('app.regular') </label> <br/>

                                                <label><input type="radio" value="premium" name="price_plan"
                                                              data-price="{{ get_ads_price('premium') }}"/>@lang('app.premium')
                                                </label>

                                                <hr/>

                                                <div class="well" id="price_summery" style="display: none;">
                                                    @lang('app.payable_amount') :
                                                    <span id="payable_amount">{{ get_option('regular_ads_price') }}</span>
                                                </div>

                                                {!! $errors->has('price_plan')? '<p class="help-block">'.$errors->first('price_plan').'</p>':'' !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('payment_method')? 'has-error':'' }}">
                                        <label for="payment_method"
                                               class="col-sm-4 control-label">@lang('app.payment_method')</label>
                                        <div class="col-sm-8">


                                            @if(get_option('enable_paypal') == 1)
                                                <label>
                                                    <input type="radio" name="payment_method" value="paypal"
                                                           @if(old('payment_method')) {{ old('payment_method') == 'paypal' ? 'selected':'' }} @else checked="checked" @endif > @lang('app.paypal')
                                                </label>
                                                <br/>
                                            @endif

                                            @if(get_option('enable_stripe') == 1)
                                                <label>
                                                    <input type="radio" name="payment_method"
                                                           value="stripe" {{ old('payment_method') == 'stripe' ? 'checked="checked"':'' }} > @lang('app.stripe')
                                                </label>
                                            @endif

                                            {!! $errors->has('payment_method')? '<p class="help-block">'.$errors->first('payment_method').'</p>':'' !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif

                        @if(get_option('enable_recaptcha_post_ad') == 1)
                            <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="g-recaptcha" data-sitekey="{{get_option('recaptcha_site_key')}}"></div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-save"></i> @lang('app.save_new_ad')</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div> <!-- #row -->

        </div> <!-- /#container -->
    </div>

@endsection

@section('page-js')

    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('content_editor');
    </script>
    <script src="{{asset('assets/plugins/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Example: Initializing the datetimepicker
            $('.datetimepicker-input').datetimepicker();
        });
    </script>
    <script type="text/javascript">

        $('#application_deadline').datepicker({
            format: "yyyy-mm-dd hh:ii",
            todayHighlight: true,
            startDate: new Date(),
            autoclose: true
        });
        $('#build_year').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker();
        });
    </script>
    <script>
        function generate_option_from_json(jsonData, fromLoad) {
            //Load Category Json Data To Brand Select
            if (fromLoad === 'country_to_state') {
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="0" selected> @lang('app.select_state') </option>';
                    for (i in jsonData) {
                        option += '<option value="' + jsonData[i].id + '"> ' + jsonData[i].state_name + ' </option>';
                    }
                    $('#state_select').html(option);
                    $('#state_select').select2();
                } else {
                    $('#state_select').html('');
                    $('#state_select').select2();
                }
                $('#state_loader').hide('slow');

            } else if (fromLoad === 'state_to_city') {
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="0" selected> @lang('app.select_city') </option>';
                    for (i in jsonData) {
                        option += '<option value="' + jsonData[i].id + '"> ' + jsonData[i].city_name + ' </option>';
                    }
                    $('#city_select').html(option);
                    $('#city_select').select2();
                } else {
                    $('#city_select').html('');
                    $('#city_select').select2();
                }
                $('#city_loader').hide('slow');
            }
        }

        $(document).ready(function () {

            $('[name="country"]').change(function () {
                var country_id = $(this).val();
                $('#state_loader').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get_state_by_country') }}',
                    data: {country_id: country_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        generate_option_from_json(data, 'country_to_state');
                    }
                });
            });

            $('[name="state"]').change(function () {
                var state_id = $(this).val();
                $('#city_loader').show();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get_city_by_state') }}',
                    data: {state_id: state_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        generate_option_from_json(data, 'state_to_city');
                    }
                });
            });

            $('body').on('click', '.imgDeleteBtn', function () {
                //Get confirm from user
                if (!confirm('{{ trans('app.are_you_sure') }}')) {
                    return '';
                }

                var current_selector = $(this);
                var img_id = $(this).closest('.img-action-wrap').attr('id');
                $.ajax({
                    url: '{{ route('delete_media') }}',
                    type: "POST",
                    data: {media_id: img_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        if (data.success == 1) {
                            current_selector.closest('.creating-ads-img-wrap').hide('slow');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });
            /**
             * Change ads price by urgent or premium
             */

            $(document).on('change', '.price_input_group', function () {
                var price = 0;
                var checkedValues = $('.price_input_group input:checked').map(function () {
                    return $(this).data('price');
                }).get();

                for (var i = 0; i < checkedValues.length; i++) {
                    price += parseInt(checkedValues[i]); //don't forget to add the base
                }

                $('#payable_amount').text(price);
                $('#price_summery').show('slow');
            });

            $(document).on('click', '.image-add-more', function (e) {
                e.preventDefault();
                $('.upload-images-input-wrap').append('<input type="file" name="images[]" class="form-control" />');
            });

        });
    </script>


    <script>
        @if(session('success'))
        toastr.success('{{ session('success') }}', '<?php echo trans('app.success') ?>', toastr_options);
        @endif
    </script>

    @if(get_option('enable_recaptcha_post_ad') == 1)
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
@endsection