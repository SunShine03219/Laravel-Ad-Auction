<?php

namespace App\Providers;

use App\Models\Option;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            if (env('APP_ENV') !== 'local') {
                URL::forceScheme('https');
            }

            DB::connection()->getPdo();

            //Auto-loading options to reduce the query
            $options = Option::all()->pluck('option_value', 'option_key')->toArray();
            $GLOBALS['options'] = $options;

            //$GLOBALS['larabid_option'] = (object)$larabidOption;

            /**
             * Set dynamic configuration for third party services
             */
            $amazonS3Config = [
                'filesystems.disks.s3' => [
                    'driver' => 's3',
                    'key' => get_option('amazon_key'),
                    'secret' => get_option('amazon_secret'),
                    'region' => get_option('amazon_region'),
                    'bucket' => get_option('bucket'),
                ],
            ];
            $facebookConfig = [
                'services.facebook' => [
                    'client_id' => get_option('fb_app_id'),
                    'client_secret' => get_option('fb_app_secret'),
                    'redirect' => url('login/facebook-callback'),
                ],
            ];
            $googleConfig = [
                'services.google' => [
                    'client_id' => get_option('google_client_id'),
                    'client_secret' => get_option('google_client_secret'),
                    'redirect' => url('login/google-callback'),
                ],
            ];
            $twitterConfig = [
                'services.twitter' => [
                    'client_id' => get_option('twitter_consumer_key'),
                    'client_secret' => get_option('twitter_consumer_secret'),
                    'redirect' => url('login/twitter-callback'),
                ],
            ];
            config($amazonS3Config);
            config($facebookConfig);
            config($googleConfig);
            config($twitterConfig);
        } catch (\Exception $e) {
            $GLOBALS['is_db_connected'] = false;
            //die("Could not connect to the database.  Please check your configuration.");
        }

        view()->composer('*', function ($view) {
            $enable_monetize = get_option('enable_monetize');
            $loggedUser = null;
            if (Auth::check()) {
                $loggedUser = Auth::user();
            }

            $current_lang = current_language();

            $view->with(['lUser' => $loggedUser, 'enable_monetize' => $enable_monetize, 'current_lang' => $current_lang]);
        });

        /**
         * components
         */
        Blade::component('PostCard', \App\View\Components\PostCard::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
