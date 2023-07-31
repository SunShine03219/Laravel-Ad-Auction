
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> @lang('app.dashboard')</a>
            </li>

            <li>
                <a href="#"><i class="fa fa-bullhorn"></i> @lang('app.my_ads')<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>  <a href="{{ route('my_ads') }}">@lang('app.my_ads')</a> </li>
                    <li>  <a href="{{ route('create_ad') }}">@lang('app.post_an_ad')</a> </li>
                    <li>  <a href="{{ route('pending_ads') }}">@lang('app.pending_for_approval')</a> </li>
                    <li>  <a href="{{ route('favorite_ads') }}">@lang('app.favourite_ads')</a> </li>
                </ul>
            </li>

            @if($lUser->is_admin())

                <li> <a href="{{ route('parent_categories') }}"><i class="fa fa-list"></i> @lang('app.categories') <span class="label label-default pull-right"><i class="fa fa-user"></i> </span></a>  </li>
                <li>
                    <a href="#"><i class="fa fa-bullhorn"></i> @lang('app.ads')<span class="fa arrow"></span> <span class="label label-default pull-right"><i class="fa fa-user"></i> </span>  </a>
                    <ul class="nav nav-second-level">
                        <li>  <a href="{{ route('approved_ads') }}">@lang('app.approved_ads')</a> </li>
                        <li>  <a href="{{ route('admin_pending_ads') }}">@lang('app.pending_for_approval')</a> </li>
                        <li>  <a href="{{ route('admin_blocked_ads') }}">@lang('app.blocked_ads')</a> </li>
                    </ul>
                </li>

                <li> <a href="{{ route('pages') }}"><i class="fa fa-file-word-o"></i> @lang('app.pages') <span class="label label-default pull-right"><i class="fa fa-user"></i> </span></a>  </li>
                <li> <a href="{{ route('admin_comments') }}"><i class="fa fa-comment-o"></i> @lang('app.comments') <span class="label label-default pull-right"><i class="fa fa-user"></i> </span></a>  </li>
                <li> <a href="{{ route('ad_reports') }}"><i class="fa fa-exclamation"></i> @lang('app.ad_reports') <span class="label label-default pull-right"><i class="fa fa-user"></i> </span></a>  </li>
                <li> <a href="{{ route('users') }}"><i class="fa fa-users"></i> @lang('app.users')</a>  </li>

                <li>
                    <a href="#"><i class="fa fa-desktop fa-fw"></i> @lang('app.appearance')<span class="fa arrow"></span> <span class="label label-default pull-right"><i class="fa fa-user"></i> </span> </a>
                    <ul class="nav nav-second-level">
                        <li> <a href="{{ route('theme_settings') }}">@lang('app.theme_settings')</a> </li>
                        <li> <a href="{{ route('social_url_settings') }}">@lang('app.social_url')</a> </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li>
                    <a href="#"><i class="fa fa-map-marker"></i> @lang('app.locations')<span class="fa arrow"></span> <span class="label label-default pull-right"><i class="fa fa-user"></i> </span> </a>
                    <ul class="nav nav-second-level">
                        <li> <a href="{{ route('country_list') }}">@lang('app.countries')</a> </li>
                        <li> <a href="{{ route('state_list') }}">@lang('app.states')</a> </li>
                        <li> <a href="{{ route('city_list') }}">@lang('app.cities')</a> </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li> <a href="{{ route('contact_messages') }}"><i class="fa fa-envelope-o"></i> @lang('app.contact_messages') <span class="label label-default pull-right"><i class="fa fa-user"></i> </span> </a>  </li>
                <li> <a href="{{ route('monetization') }}"><i class="fa fa-dollar"></i> @lang('app.monetization') <span class="label label-default pull-right"><i class="fa fa-user"></i> </span> </a>  </li>

                <li>
                    <a href="#"><i class="fa fa-wrench fa-fw"></i> @lang('app.settings')<span class="fa arrow"></span> <span class="label label-default pull-right"><i class="fa fa-user"></i> </span> </a>
                    <ul class="nav nav-second-level">
                        <li> <a href="{{ route('general_settings') }}">@lang('app.general_settings')</a> </li>
                        <li> <a href="{{ route('ad_settings') }}">@lang('app.ad_settings_and_pricing')</a> </li>
                        <li> <a href="{{ route('payment_settings') }}">@lang('app.payment_settings')</a> </li>
                        <li> <a href="{{ route('language_settings') }}">@lang('app.language_settings')</a> </li>
                        <li> <a href="{{ route('file_storage_settings') }}">@lang('app.file_storage_settings')</a> </li>
                        <li> <a href="{{ route('social_settings') }}">@lang('app.social_settings')</a> </li>
                        <li> <a href="{{ route('re_captcha_settings') }}">@lang('app.re_captcha_settings')</a> </li>
                        <li> <a href="{{ route('other_settings') }}">@lang('app.other_settings')</a> </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li> <a href="{{ route('administrators') }}"><i class="fa fa-users"></i> @lang('app.administrators') <span class="label label-default pull-right"><i class="fa fa-user"></i> </span> </a>  </li>


            @endif

            <li> <a href="{{ route('payments') }}"><i class="fa fa-money"></i> @lang('app.payments')</a>  </li>
            <li> <a href="{{ route('profile') }}"><i class="fa fa-user"></i> @lang('app.profile')</a>  </li>
            <li> <a href="{{ route('change_password') }}"><i class="fa fa-lock"></i> @lang('app.change_password')</a>  </li>


        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
