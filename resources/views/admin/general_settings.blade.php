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

                <div class="row">
                    <div class="col-md-10 col-xs-12">

                        <form action="{{route('save_settings')}}" class="form-horizontal" method="post" enctype="multipart/form-data"> @csrf

                        <div class="form-group {{ $errors->has('site_name')? 'has-error':'' }}">
                            <label for="site_name" class="col-sm-4 control-label">@lang('app.site_name')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="site_name" value="{{ old('site_name')? old('site_name') : get_option('site_name') }}" name="site_name" placeholder="@lang('app.site_name')">
                                {!! $errors->has('site_name')? '<p class="help-block">'.$errors->first('site_name').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('site_title')? 'has-error':'' }}">
                            <label for="site_title" class="col-sm-4 control-label">@lang('app.site_title')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="site_title" value="{{ old('site_title')? old('site_title') : get_option('site_title') }}" name="site_title" placeholder="@lang('app.site_title')">
                                {!! $errors->has('site_title')? '<p class="help-block">'.$errors->first('site_title').'</p>':'' !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email_address')? 'has-error':'' }}">
                            <label for="email_address" class="col-sm-4 control-label">@lang('app.email_address')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email_address" value="{{ old('email_address')? old('email_address') : get_option('email_address') }}" name="email_address" placeholder="@lang('app.email_address')">
                                {!! $errors->has('email_address')? '<p class="help-block">'.$errors->first('email_address').'</p>':'' !!}
                                <p class="text-info"> @lang('app.email_address_help_text')</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="default_timezone" class="col-sm-4 control-label">
                                @lang('app.default_timezone')
                            </label>
                            <div class="col-sm-8 {{ $errors->has('default_timezone')? 'has-error':'' }}">
                                <select class="form-control select2" name="default_timezone" id="default_timezone">
                                    @php $saved_timezone = get_option('default_timezone'); @endphp
                                    @foreach(timezone_identifiers_list() as $key=>$value)
                                        <option value="{{ $value }}" {{ $saved_timezone == $value? 'selected':'' }}>{{ $value }}</option>
                                    @endforeach

                                </select>


                                {!! $errors->has('default_timezone')? '<p class="help-block">'.$errors->first('default_timezone').'</p>':'' !!}
                                <p class="text-info">@lang('app.default_timezone_help_text')</p>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('date_format')? 'has-error':'' }}">
                            <label for="email_address" class="col-sm-4 control-label">@lang('app.date_format')</label>
                            <div class="col-sm-8">
                                <fieldset>
                                    @php $saved_date_format = get_option('date_format'); @endphp

                                    <label><input type="radio" value="F j, Y" name="date_format" {{ $saved_date_format == 'F j, Y'? 'checked':'' }}> {{ date('F j, Y') }}<code>F j, Y</code></label> <br />
                                    <label><input type="radio" value="Y-m-d" name="date_format" {{ $saved_date_format == 'Y-m-d'? 'checked':'' }}> {{ date('Y-m-d') }}<code>Y-m-d</code></label> <br />

                                    <label><input type="radio" value="m/d/Y" name="date_format" {{ $saved_date_format == 'm/d/Y'? 'checked':'' }}> {{ date('m/d/Y') }}<code>m/d/Y</code></label> <br />

                                    <label><input type="radio" value="d/m/Y" name="date_format" {{ $saved_date_format == 'd/m/Y'? 'checked':'' }}> {{ date('d/m/Y') }}<code>d/m/Y</code></label> <br />

                                    <label><input type="radio" value="custom" name="date_format" {{ $saved_date_format == 'custom'? 'checked':'' }}> Custom:</label>
                                    <input type="text" value="{{ get_option('date_format_custom') }}" id="date_format_custom" name="date_format_custom" />
                                    <span>example: {{ date(get_option('date_format_custom')) }}</span>
                                </fieldset>
                                <p class="text-info"> @lang('app.date_format_help_text')</p>
                            </div>
                        </div>



                        <div class="form-group {{ $errors->has('time_format')? 'has-error':'' }}">
                            <label for="email_address" class="col-sm-4 control-label">@lang('app.time_format')</label>
                            <div class="col-sm-8">
                                <fieldset>
                                    <label><input type="radio" value="g:i a" name="time_format" {{ get_option('time_format') == 'g:i a'? 'checked':'' }}> {{ date('g:i a') }}<code>g:i a</code></label> <br />
                                    <label><input type="radio" value="g:i A" name="time_format" {{ get_option('time_format') == 'g:i A'? 'checked':'' }}> {{ date('g:i A') }}<code>g:i A</code></label> <br />

                                    <label><input type="radio" value="H:i" name="time_format" {{ get_option('time_format') == 'H:i'? 'checked':'' }}> {{ date('H:i') }}<code>H:i</code></label> <br />

                                    <label><input type="radio" value="custom" name="time_format" {{ get_option('time_format') == 'custom'? 'checked':'' }}> Custom:</label>
                                    <input type="text" value="{{ get_option('time_format_custom') }}" id="time_format_custom" name="time_format_custom" />
                                    <span>example: {{ date(get_option('time_format_custom')) }}</span>
                                </fieldset>
                                <p><a href="http://php.net/manual/en/function.date.php" target="_blank">@lang('app.date_time_read_more')</a> </p>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('currency_sign')? 'has-error':'' }}">
                            <label for="currency_sign" class="col-sm-4 control-label">@lang('app.currency_sign')</label>
                            <div class="col-sm-8">
                                <?php $current_currency = get_option('currency_sign'); ?>
                                <select name="currency_sign" class="form-control select2">
                                    @foreach(themeqx_classifieds_currencies() as $code => $name)
                                        <option value="{{ $code }}"  {{ $current_currency == $code? 'selected':'' }}> {{ $code }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('currency_position')? 'has-error':'' }}">
                            <label for="currency_position" class="col-sm-4 control-label">@lang('app.currency_position')</label>
                            <div class="col-sm-8">
                                <?php $currency_position = get_option('currency_position'); ?>
                                <select name="currency_position" class="form-control select2">
                                    <option value="left" @if($currency_position == 'left') selected="selected" @endif >@lang('app.left')</option>
                                    <option value="right" @if($currency_position == 'right') selected="selected" @endif >@lang('app.right')</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('logo_settings')? 'has-error':'' }}">
                            <label for="email_address" class="col-sm-4 control-label">@lang('app.logo_settings')</label>
                            <div class="col-sm-8">
                                <fieldset>
                                    <label><input type="radio" value="show_site_name" name="logo_settings" {{ get_option('logo_settings') == 'show_site_name'? 'checked':'' }}> @lang('app.show_site_name') </label> <br />
                                    <label><input type="radio" value="show_image" name="logo_settings" {{ get_option('logo_settings') == 'show_image'? 'checked':'' }}> @lang('app.show_image') </label> <br />
                                </fieldset>
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('verification_email_after_registration')? 'has-error':'' }}">
                            <label for="email_address" class="col-sm-4 control-label">@lang('app.verification_email_after_registration')</label>
                            <div class="col-sm-8">
                                <fieldset>
                                    <label><input type="radio" value="1" name="verification_email_after_registration" {{ get_option('verification_email_after_registration') == '1'? 'checked':'' }}> @lang('app.yes') </label> <br />
                                    <label><input type="radio" value="0" name="verification_email_after_registration" {{ get_option('verification_email_after_registration') == '0'? 'checked':'' }}> @lang('app.no') </label> <br />
                                </fieldset>
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('enable_google_maps')? 'has-error':'' }}">
                            <label for="email_address" class="col-sm-4 control-label">@lang('app.enable_google_maps')</label>
                            <div class="col-sm-8">
                                <fieldset>
                                    <label><input type="radio" value="1" name="enable_google_maps" {{ get_option('enable_google_maps') == '1'? 'checked':'' }}> @lang('app.yes') </label> <br />
                                    <label><input type="radio" value="0" name="enable_google_maps" {{ get_option('enable_google_maps') == '0'? 'checked':'' }}> @lang('app.no') </label> <br />
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('google_map_api_key')? 'has-error':'' }}">
                            <label for="google_map_api_key" class="col-sm-4 control-label">@lang('app.google_map_api_key')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="google_map_api_key" value="{{ old('google_map_api_key')? old('google_map_api_key') : get_option('google_map_api_key') }}" name="google_map_api_key" placeholder="@lang('app.google_map_api_key')">
                                <p class="help-block"> @lang('app.google_map_api_key_get_info') <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">https://developers.google.com/maps/documentation/javascript/get-api-key</a> </p>
                                {!! $errors->has('google_map_api_key')? '<p class="help-block">'.$errors->first('google_map_api_key').'</p>':'' !!}
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('enable_comments')? 'has-error':'' }}">
                            <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
                            <div class="col-md-8">
                                <label for="enable_comments" class="checkbox-inline">
                                    <input type="checkbox" value="1" id="enable_comments" name="enable_comments" {{ get_option('enable_comments') == 1 ? 'checked="checked"': '' }}>
                                    @lang('app.enable_comments')
                                </label>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('enable_fb_comments')? 'has-error':'' }}">
                            <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
                            <div class="col-md-8">
                                <label for="enable_fb_comments" class="checkbox-inline">
                                    <input type="checkbox" value="1" id="enable_fb_comments" name="enable_fb_comments" {{ get_option('enable_fb_comments') == 1 ? 'checked="checked"': '' }}>
                                    @lang('app.enable_fb_comments')
                                </label>
                            </div>
                        </div>


                        <legend>@lang('app.contact_us_page')</legend>

                        <div class="form-group">
                            <label for="google_map_embedded_code" class="col-sm-4 control-label">@lang('app.google_map_embedded_code') </label>
                            <div class="col-sm-8">
                                <textarea name="google_map_embedded_code" class="form-control">{{ get_option('google_map_embedded_code') }}</textarea>
                                <a href="https://support.google.com/maps/answer/144361" target="_blank">@lang('app.google_map_embedded_code_help_text')</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="footer_address" class="col-sm-4 control-label">@lang('app.footer_address') </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="footer_address" value="{{ get_option('footer_address') }}" name="footer_address" placeholder="@lang('app.footer_address')">
                                <p class="text-info">@lang('app.footer_address_help_text')</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="site_phone_number" class="col-sm-4 control-label">@lang('app.site_phone_number') </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="site_phone_number" value="{{ get_option('site_phone_number') }}" name="site_phone_number" placeholder="@lang('app.site_phone_number')">
                                <p class="text-info">@lang('app.site_phone_number_help_text')</p>

                            </div>
                        </div>

                        <hr />

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" id="settings_save_btn" class="btn btn-primary">@lang('app.save_settings')</button>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>

            </div>   <!-- /#page-wrapper -->

        </div>   <!-- /#wrapper -->


    </div> <!-- /#container -->
@endsection


@section('page-js')
    <script>
        $(document).ready(function(){

            $('input[type="checkbox"], input[type="radio"]').click(function(){
                var input_name = $(this).attr('name');
                var input_value = 0;
                if ($(this).prop('checked')){
                    input_value = $(this).val();
                }
                $.ajax({
                    url : '{{ route('save_settings') }}',
                    type: "POST",
                    data: { [input_name]: input_value, '_token': '{{ csrf_token() }}' },
                });
            });


            $('input[name="date_format"]').click(function(){
                $('#date_format_custom').val($(this).val());
            });
            $('input[name="time_format"]').click(function(){
                $('#time_format_custom').val($(this).val());
            });

            /**
             * Send settings option value to server
             */
            $('#settings_save_btn').click(function(e){
                e.preventDefault();

                var this_btn = $(this);
                this_btn.attr('disabled', 'disabled');

                var form_data = this_btn.closest('form').serialize();
                $.ajax({
                    url : '{{ route('save_settings') }}',
                    type: "POST",
                    data: form_data,
                    success : function (data) {
                        if (data.success == 1){
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }else {
                            toastr.warning(data.msg, '@lang('app.error')', toastr_options);
                        }
                        this_btn.removeAttr('disabled');
                    }
                });
            });

        });
    </script>
@endsection