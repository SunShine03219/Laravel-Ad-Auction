@extends('layouts.app')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')

    <div class="dashboard-wrap">
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

                    <form action="{{route('save_settings')}}" class="form-horizontal" method="post" enctype="multipart/form-data"> @csrf


                    <div id="social_login_settings_wrap">

                        {{--<div class="form-group {{ $errors->has('enable_recaptcha_login')? 'has-error':'' }}">
                            <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
                            <div class="col-md-8">
                                <label for="enable_recaptcha_login" class="checkbox-inline">
                                    <input type="checkbox" value="1" id="enable_recaptcha_login" name="enable_recaptcha_login" {{ get_option('enable_recaptcha_login') == 1 ? 'checked="checked"': '' }}>
                                    @lang('app.enable_recaptcha_login')
                                </label>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('enable_recaptcha_registration')? 'has-error':'' }}">
                            <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
                            <div class="col-md-8">
                                <label for="enable_recaptcha_registration" class="checkbox-inline">
                                    <input type="checkbox" value="1" id="enable_recaptcha_registration" name="enable_recaptcha_registration" {{ get_option('enable_recaptcha_registration') == 1 ? 'checked="checked"': '' }}>
                                    @lang('app.enable_recaptcha_registration')
                                </label>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('enable_recaptcha_contact_form')? 'has-error':'' }}">
                            <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
                            <div class="col-md-8">
                                <label for="enable_recaptcha_contact_form" class="checkbox-inline">
                                    <input type="checkbox" value="1" id="enable_recaptcha_contact_form" name="enable_recaptcha_contact_form" {{ get_option('enable_recaptcha_contact_form') == 1 ? 'checked="checked"': '' }}>
                                    @lang('app.enable_recaptcha_contact_form')
                                </label>
                            </div>
                        </div>--}}

                        <div class="form-group {{ $errors->has('enable_recaptcha_post_ad')? 'has-error':'' }}">
                            <label class="col-md-4 control-label">@lang('app.enable_disable') </label>
                            <div class="col-md-8">
                                <label for="enable_recaptcha_post_ad" class="checkbox-inline">
                                    <input type="checkbox" value="1" id="enable_recaptcha_post_ad" name="enable_recaptcha_post_ad" {{ get_option('enable_recaptcha_post_ad') == 1 ? 'checked="checked"': '' }}>
                                    @lang('app.enable_recaptcha_post_ad')
                                </label>
                            </div>
                        </div>
                        

                        <hr />
                        <div class="form-group">
                            <label for="recaptcha_site_key" class="col-sm-4 control-label">@lang('app.site_key')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="site_key" value="{{ get_option('recaptcha_site_key') }}" name="recaptcha_site_key" placeholder="@lang('app.site_key')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="recaptcha_secret_key" class="col-sm-4 control-label">@lang('app.secret_key')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="recaptcha_secret_key" value="{{ get_option('recaptcha_secret_key') }}" name="recaptcha_secret_key" placeholder="@lang('app.secret_key')">
                            </div>
                        </div>



                    </div>

                    <hr />

                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" id="settings_save_btn" class="btn btn-primary">@lang('app.save_settings')</button>
                        </div>
                    </div>

                    </form>

                </div>   <!-- /#page-wrapper -->

            </div>   <!-- /#wrapper -->


        </div> <!-- /#container -->
    </div> <!-- /#dashboard -->
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
                    data: { [input_name]: input_value, '_token': '{{ csrf_token() }}' }
                });
            });

            /**
             * show or hide stripe and paypal settings wrap
             */
            $('#enable_facebook_login').click(function(){
                if ($(this).prop('checked')){
                    $('#facebook_login_api_wrap').slideDown();
                }else{
                    $('#facebook_login_api_wrap').slideUp();
                }
            });
            $('#enable_google_login').click(function(){
                if ($(this).prop('checked')){
                    $('#google_login_api_wrap').slideDown();
                }else{
                    $('#google_login_api_wrap').slideUp();
                }
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
                            this_btn.removeAttr('disabled');
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });

        });
    </script>
@endsection