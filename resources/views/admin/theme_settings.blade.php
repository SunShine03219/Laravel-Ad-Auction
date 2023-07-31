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

                <form action="{{route('save_settings')}}" class="form-horizontal" method="post" enctype="multipart/form-data"> @csrf

                    <h4>@lang('app.variable_info')</h4>
                    <pre>[year], [copyright_sign], [site_name]</pre>
                    <hr />


                    <div class="form-group">
                        <label for="additional_css" class="col-sm-4 control-label">@lang('app.additional_css') </label>
                        <div class="col-sm-8">
                            <textarea name="additional_css" class="form-control">{{ get_option('additional_css') }}</textarea>
                            <p class="text-info">@lang('app.additional_css_help_text')</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="additional_js" class="col-sm-4 control-label">@lang('app.additional_js') </label>
                        <div class="col-sm-8">
                            <textarea name="additional_js" class="form-control">{{ get_option('additional_js') }}</textarea>
                            <p class="text-info">@lang('app.additional_js_help_text')</p>
                        </div>
                    </div>

                    <legend>@lang('app.footer')</legend>

                    <div class="form-group">
                        <label for="footer_company_name" class="col-sm-4 control-label">@lang('app.footer_company_name') </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="footer_company_name" value="{{ get_option('footer_company_name') }}" name="footer_company_name" placeholder="@lang('app.footer_company_name')">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="footer_copyright_text" class="col-sm-4 control-label">@lang('app.footer_copyright_text') </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="footer_copyright_text" value="{{ get_option('footer_copyright_text') }}" name="footer_copyright_text" placeholder="@lang('app.footer_copyright_text')">
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