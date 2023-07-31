@if(get_option('enable_social_login') == 1)
    <div class="row row-sm-offset-3 socialButtons">
        @if(get_option('enable_facebook_login') == 1)
            <div class="col-xs-4">
                <a href="{{ route('facebook_redirect') }}" class="btn btn-lg btn-block btn-facebook">
                    <i class="fa fa-facebook visible-xs"></i>
                    <span class="hidden-xs"><i class="fa fa-facebook-square"></i> Facebook</span>
                </a>
            </div>
        @endif

        @if(get_option('enable_google_login') == 1)
            <div class="col-xs-4">
                <a href="{{ route('google_redirect') }}" class="btn btn-lg btn-block btn-google">
                    <i class="fa fa-google-plus visible-xs"></i>
                    <span class="hidden-xs"><i class="fa fa-google-plus-square"></i> Google+</span>
                </a>
            </div>
        @endif
        @if(get_option('enable_twitter_login') == 1)
            <div class="col-xs-4">
                <a href="{{ route('twitter_redirect') }}" class="btn btn-lg btn-block btn-twitter">
                    <i class="fa fa-google-plus visible-xs"></i>
                    <span class="hidden-xs"><i class="fa fa-twitter"></i> Twitter</span>
                </a>
            </div>
        @endif
    </div>
    <hr />
@endif