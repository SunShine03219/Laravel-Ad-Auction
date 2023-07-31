<?php
/**
 * @return mixed
 * Custom functions made by themeqx
 */
require __DIR__.'/laravel_helpers.php';

/**
 * @param  string  $img (object)
 * @param  bool  $full_size
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
 */
function media_url($img = '', $full_size = false)
{
    $url_path = asset('assets/img/classified-placeholder.png');

    if ($img) {
        if ($img->type == 'image') {
            if ($img->storage == 'public') {
                if ($full_size) {
                    $url_path = asset('uploads/images/'.$img->media_name);
                } else {
                    $url_path = asset('uploads/images/thumbs/'.$img->media_name);
                }
            } elseif ($img->storage == 's3') {
                if ($full_size) {
                    $url_path = \Illuminate\Support\Facades\Storage::disk('s3')->url('uploads/images/'.$img->media_name);
                } else {
                    $url_path = \Illuminate\Support\Facades\Storage::disk('s3')->url('uploads/images/thumbs/'.$img->media_name);
                }
            }
        }
    }

    return $url_path;
}

/**
 * @param  null  $resume
 * @return null|string
 */
if (! function_exists('resume_url')) {
    function resume_url($resume = null)
    {
        $url_path = null;
        if ($resume) {
            $source = get_option('default_storage');
            if ($source == 'public') {
                $url_path = asset('uploads/resume/'.$resume);
            } elseif ($source == 's3') {
                $url_path = \Illuminate\Support\Facades\Storage::disk('s3')->url('uploads/resume/'.$resume);
            }
        }

        return $url_path;
    }
}

function avatar_img_url($img, $source)
{
    $url_path = '';
    if ($img) {
        if ($source == 'public') {
            $url_path = asset('uploads/avatar/'.$img);
        } elseif ($source == 's3') {
            $url_path = \Illuminate\Support\Facades\Storage::disk('s3')->url('uploads/avatar/'.$img);
        }
    }

    return $url_path;
}

/**
 * @return string
 * @return logo url
 */
function logo_url()
{
    $url_path = '';
    $img = get_option('logo');
    $source = get_option('logo_storage');

    if ($source == 'public') {
        $url_path = asset('uploads/logo/'.$img);
    } elseif ($source == 's3') {
        $url_path = \Illuminate\Support\Facades\Storage::disk('s3')->url('uploads/logo/'.$img);
    }

    return $url_path;
}

/**
 * @return mixed
 */
function current_disk()
{
    $current_disk = \Illuminate\Support\Facades\Storage::disk(get_option('default_storage'));

    return $current_disk;
}

/**
 * @param  string  $option_key
 * @return string
 */
function get_option($option_key = '')
{
    global $options;

    if (array_key_exists($option_key, $options)) {
        return $options[$option_key];
    }

    return $option_key;
}

/**
 * @param  string  $text
 * @return mixed
 */
function get_text_tpl($text = '')
{
    $tpl = ['[year]', '[copyright_sign]', '[site_name]'];
    $variable = [date('Y'), '&copy;', get_option('site_name')];

    $tpl_option = str_replace($tpl, $variable, $text);

    return $tpl_option;
}

/**
 * @param  string  $title
 * @return string
 */
function unique_slug($title = '', $model = 'Ad')
{
    $slug = str_slug($title);
    //get unique slug...
    $nSlug = $slug;
    $i = 0;

    $model = str_replace(' ', '', "\App\Models\ ".$model);

    while (($model::whereSlug($nSlug)->count()) > 0) {
        $i++;
        $nSlug = $slug.'-'.$i;
    }
    if ($i > 0) {
        $newSlug = substr($nSlug, 0, strlen($slug)).'-'.$i;
    } else {
        $newSlug = $slug;
    }

    return $newSlug;
}

/**
 * @param  string  $plan
 * @return int|string
 */
function get_ads_price($plan = 'regular')
{
    $price = 0;

    if ($plan == 'regular') {
        if (get_option('ads_price_plan') == 'all_ads_paid') {
            $price = get_option('regular_ads_price');
        }
    } elseif ($plan == 'premium') {
        if (get_option('ads_price_plan') != 'all_ads_free') {
            $price = get_option('premium_ads_price');
        }
    }

    return $price;
}

/**
 * @return \Illuminate\Database\Eloquent\Collection|static[]
 */
if (! function_exists('get_languages')) {
    function get_languages()
    {
        $languages = \App\Models\Language::all();

        return $languages;
    }
}

function current_language()
{
    if (session('lang')) {
        $language = \App\Models\Language::whereLanguageCode(session('lang'))->first();
        if ($language) {
            return $language;
        }
    }

    return false;
}

/**
 * @return bool
 */
if (! function_exists('is_rtl')) {
    function is_rtl()
    {
        $current_language = current_language();
        if ($current_language) {
            if ($current_language->is_rtl == 1) {
                return true;
            }
        }

        return false;
    }
}

/**
 * @param  string  $type
 * @return string
 * @return stripe secret key or test key
 */
function get_stripe_key($type = 'publishable')
{
    $stripe_key = '';

    if ($type == 'publishable') {
        if (get_option('stripe_test_mode') == 1) {
            $stripe_key = get_option('stripe_test_publishable_key');
        } else {
            $stripe_key = get_option('stripe_live_publishable_key');
        }
    } elseif ($type == 'secret') {
        if (get_option('stripe_test_mode') == 1) {
            $stripe_key = get_option('stripe_test_secret_key');
        } else {
            $stripe_key = get_option('sk_live_ojldRoMZ3j14I5pwpfCxidvT');
        }
    }

    return $stripe_key;
}

/**
 * @return bool
 *
 * return all fa icon list
 */
function fa_icons()
{
    $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"\\\\(.+)";\s+}/';
    $subject = file_get_contents(public_path('assets/font-awesome-4.4.0/css/font-awesome.css'));
    preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        $icons[$match[1]] = $match[2];
    }
    ksort($icons);

    return $icons;
}

function category_classes()
{
    $classes = [
        'green' => 'green',
        'gold' => 'gold',
        'purple' => 'purple',
        'orange' => 'orange',
        'brick' => 'brick',
        'blue' => 'blue',
        'honey' => 'honey',
    ];

    return $classes;
}

/**
 * @param  int  $price
 * @return string
 */
function themeqx_price($price = 0)
{
    $show_price = '';
    if ($price > 0) {
        $price = number_format($price, 2);
        $currency_position = get_option('currency_position');
        $currency_sign = classified_currency_symbol(get_option('currency_sign'));

        if ($currency_position == 'right') {
            $show_price = $price.$currency_sign;
        } else {
            $show_price = $currency_sign.$price;
        }
    }

    return $show_price;
}

/**
 * @param  int  $price
 * @param  int  $negotiable
 * @return string
 */
function themeqx_price_ng($price = 0, $negotiable = 0)
{
    $ng = $negotiable ? ' ('.trans('app.negotiable').') ' : '';
    $show_price = '';
    if ($price > 0) {
        $price = number_format($price, 2);
        $currency_position = get_option('currency_position');
        $currency_sign = classified_currency_symbol(get_option('currency_sign'));

        if ($currency_position == 'right') {
            $show_price = $price.' '.$currency_sign;
        } else {
            $show_price = $currency_sign.' '.$price;
        }
    }

    return $show_price.$ng;
}

/**
 * @return mixed|string
 */
if (! function_exists('currency_sign')) {
    function currency_sign()
    {
        $currency_sign = classified_currency_symbol(get_option('currency_sign'));

        return $currency_sign;
    }
}

function update_option($key, $value)
{
    $option = \App\Models\Option::firstOrCreate(['option_key' => $key]);
    $option->option_value = $value;

    return $option->save();
}

if (! function_exists('safe_output')) {
    function safe_output($text = null)
    {
        if ($text) {
            $text = strip_tags($text, '<h1><h2><h3><h4><h5><h6><p><br><ul><li><hr><a><abbr><address><b><blockquote><center><cite><code><del><i><ins><strong><sub><sup><time><u><img><iframe><link><nav><ol><table><caption><th><tr><td><thead><tbody><tfoot><col><colgroup><div><span>');

            $text = str_replace('javascript:', '', $text);
        }

        return $text;
    }
}

function themeqx_classifieds_currencies()
{
    return [
        'AED' => 'United Arab Emirates dirham',
        'AFN' => 'Afghan afghani',
        'ALL' => 'Albanian lek',
        'AMD' => 'Armenian dram',
        'ANG' => 'Netherlands Antillean guilder',
        'AOA' => 'Angolan kwanza',
        'ARS' => 'Argentine peso',
        'AUD' => 'Australian dollar',
        'AWG' => 'Aruban florin',
        'AZN' => 'Azerbaijani manat',
        'BAM' => 'Bosnia and Herzegovina convertible mark',
        'BBD' => 'Barbadian dollar',
        'BDT' => 'Bangladeshi taka',
        'BGN' => 'Bulgarian lev',
        'BHD' => 'Bahraini dinar',
        'BIF' => 'Burundian franc',
        'BMD' => 'Bermudian dollar',
        'BND' => 'Brunei dollar',
        'BOB' => 'Bolivian boliviano',
        'BRL' => 'Brazilian real',
        'BSD' => 'Bahamian dollar',
        'BTC' => 'Bitcoin',
        'BTN' => 'Bhutanese ngultrum',
        'BWP' => 'Botswana pula',
        'BYR' => 'Belarusian ruble',
        'BZD' => 'Belize dollar',
        'CAD' => 'Canadian dollar',
        'CDF' => 'Congolese franc',
        'CHF' => 'Swiss franc',
        'CLP' => 'Chilean peso',
        'CNY' => 'Chinese yuan',
        'COP' => 'Colombian peso',
        'CRC' => 'Costa Rican col&oacute;n',
        'CUC' => 'Cuban convertible peso',
        'CUP' => 'Cuban peso',
        'CVE' => 'Cape Verdean escudo',
        'CZK' => 'Czech koruna',
        'DJF' => 'Djiboutian franc',
        'DKK' => 'Danish krone',
        'DOP' => 'Dominican peso',
        'DZD' => 'Algerian dinar',
        'EGP' => 'Egyptian pound',
        'ERN' => 'Eritrean nakfa',
        'ETB' => 'Ethiopian birr',
        'EUR' => 'Euro',
        'FJD' => 'Fijian dollar',
        'FKP' => 'Falkland Islands pound',
        'GBP' => 'Pound sterling',
        'GEL' => 'Georgian lari',
        'GGP' => 'Guernsey pound',
        'GHS' => 'Ghana cedi',
        'GIP' => 'Gibraltar pound',
        'GMD' => 'Gambian dalasi',
        'GNF' => 'Guinean franc',
        'GTQ' => 'Guatemalan quetzal',
        'GYD' => 'Guyanese dollar',
        'HKD' => 'Hong Kong dollar',
        'HNL' => 'Honduran lempira',
        'HRK' => 'Croatian kuna',
        'HTG' => 'Haitian gourde',
        'HUF' => 'Hungarian forint',
        'IDR' => 'Indonesian rupiah',
        'ILS' => 'Israeli new shekel',
        'IMP' => 'Manx pound',
        'INR' => 'Indian rupee',
        'IQD' => 'Iraqi dinar',
        'IRR' => 'Iranian rial',
        'ISK' => 'Icelandic kr&oacute;na',
        'JEP' => 'Jersey pound',
        'JMD' => 'Jamaican dollar',
        'JOD' => 'Jordanian dinar',
        'JPY' => 'Japanese yen',
        'KES' => 'Kenyan shilling',
        'KGS' => 'Kyrgyzstani som',
        'KHR' => 'Cambodian riel',
        'KMF' => 'Comorian franc',
        'KPW' => 'North Korean won',
        'KRW' => 'South Korean won',
        'KWD' => 'Kuwaiti dinar',
        'KYD' => 'Cayman Islands dollar',
        'KZT' => 'Kazakhstani tenge',
        'LAK' => 'Lao kip',
        'LBP' => 'Lebanese pound',
        'LKR' => 'Sri Lankan rupee',
        'LRD' => 'Liberian dollar',
        'LSL' => 'Lesotho loti',
        'LYD' => 'Libyan dinar',
        'MAD' => 'Moroccan dirham',
        'MDL' => 'Moldovan leu',
        'MGA' => 'Malagasy ariary',
        'MKD' => 'Macedonian denar',
        'MMK' => 'Burmese kyat',
        'MNT' => 'Mongolian t&ouml;gr&ouml;g',
        'MOP' => 'Macanese pataca',
        'MRO' => 'Mauritanian ouguiya',
        'MUR' => 'Mauritian rupee',
        'MVR' => 'Maldivian rufiyaa',
        'MWK' => 'Malawian kwacha',
        'MXN' => 'Mexican peso',
        'MYR' => 'Malaysian ringgit',
        'MZN' => 'Mozambican metical',
        'NAD' => 'Namibian dollar',
        'NGN' => 'Nigerian naira',
        'NIO' => 'Nicaraguan c&oacute;rdoba',
        'NOK' => 'Norwegian krone',
        'NPR' => 'Nepalese rupee',
        'NZD' => 'New Zealand dollar',
        'OMR' => 'Omani rial',
        'PAB' => 'Panamanian balboa',
        'PEN' => 'Peruvian nuevo sol',
        'PGK' => 'Papua New Guinean kina',
        'PHP' => 'Philippine peso',
        'PKR' => 'Pakistani rupee',
        'PLN' => 'Polish z&#x142;oty',
        'PRB' => 'Transnistrian ruble',
        'PYG' => 'Paraguayan guaran&iacute;',
        'QAR' => 'Qatari riyal',
        'RON' => 'Romanian leu',
        'RSD' => 'Serbian dinar',
        'RUB' => 'Russian ruble',
        'RWF' => 'Rwandan franc',
        'SAR' => 'Saudi riyal',
        'SBD' => 'Solomon Islands dollar',
        'SCR' => 'Seychellois rupee',
        'SDG' => 'Sudanese pound',
        'SEK' => 'Swedish krona',
        'SGD' => 'Singapore dollar',
        'SHP' => 'Saint Helena pound',
        'SLL' => 'Sierra Leonean leone',
        'SOS' => 'Somali shilling',
        'SRD' => 'Surinamese dollar',
        'SSP' => 'South Sudanese pound',
        'STD' => 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra',
        'SYP' => 'Syrian pound',
        'SZL' => 'Swazi lilangeni',
        'THB' => 'Thai baht',
        'TJS' => 'Tajikistani somoni',
        'TMT' => 'Turkmenistan manat',
        'TND' => 'Tunisian dinar',
        'TOP' => 'Tongan pa&#x2bb;anga',
        'TRY' => 'Turkish lira',
        'TTD' => 'Trinidad and Tobago dollar',
        'TWD' => 'New Taiwan dollar',
        'TZS' => 'Tanzanian shilling',
        'UAH' => 'Ukrainian hryvnia',
        'UGX' => 'Ugandan shilling',
        'USD' => 'United States dollar',
        'UYU' => 'Uruguayan peso',
        'UZS' => 'Uzbekistani som',
        'VEF' => 'Venezuelan bol&iacute;var',
        'VND' => 'Vietnamese &#x111;&#x1ed3;ng',
        'VUV' => 'Vanuatu vatu',
        'WST' => 'Samoan t&#x101;l&#x101;',
        'XAF' => 'Central African CFA franc',
        'XCD' => 'East Caribbean dollar',
        'XOF' => 'West African CFA franc',
        'XPF' => 'CFP franc',
        'YER' => 'Yemeni rial',
        'ZAR' => 'South African rand',
        'ZMW' => 'Zambian kwacha',
    ];
}

/**
 * @param  string  $currency
 * @return mixed|string
 */
if (! function_exists('classified_currency_symbol')) {
    function classified_currency_symbol($currency = '')
    {
        $currency = strtoupper($currency);

        $symbols = [
            'AED' => '&#x62f;.&#x625;',
            'AFN' => '&#x60b;',
            'ALL' => 'L',
            'AMD' => 'AMD',
            'ANG' => '&fnof;',
            'AOA' => 'Kz',
            'ARS' => '&#36;',
            'AUD' => '&#36;',
            'AWG' => '&fnof;',
            'AZN' => 'AZN',
            'BAM' => 'KM',
            'BBD' => '&#36;',
            'BDT' => '&#2547;&nbsp;',
            'BGN' => '&#1083;&#1074;.',
            'BHD' => '.&#x62f;.&#x628;',
            'BIF' => 'Fr',
            'BMD' => '&#36;',
            'BND' => '&#36;',
            'BOB' => 'Bs.',
            'BRL' => '&#82;&#36;',
            'BSD' => '&#36;',
            'BTC' => '&#3647;',
            'BTN' => 'Nu.',
            'BWP' => 'P',
            'BYR' => 'Br',
            'BZD' => '&#36;',
            'CAD' => '&#36;',
            'CDF' => 'Fr',
            'CHF' => '&#67;&#72;&#70;',
            'CLP' => '&#36;',
            'CNY' => '&yen;',
            'COP' => '&#36;',
            'CRC' => '&#x20a1;',
            'CUC' => '&#36;',
            'CUP' => '&#36;',
            'CVE' => '&#36;',
            'CZK' => '&#75;&#269;',
            'DJF' => 'Fr',
            'DKK' => 'DKK',
            'DOP' => 'RD&#36;',
            'DZD' => '&#x62f;.&#x62c;',
            'EGP' => 'EGP',
            'ERN' => 'Nfk',
            'ETB' => 'Br',
            'EUR' => '&euro;',
            'FJD' => '&#36;',
            'FKP' => '&pound;',
            'GBP' => '&pound;',
            'GEL' => '&#x10da;',
            'GGP' => '&pound;',
            'GHS' => '&#x20b5;',
            'GIP' => '&pound;',
            'GMD' => 'D',
            'GNF' => 'Fr',
            'GTQ' => 'Q',
            'GYD' => '&#36;',
            'HKD' => '&#36;',
            'HNL' => 'L',
            'HRK' => 'Kn',
            'HTG' => 'G',
            'HUF' => '&#70;&#116;',
            'IDR' => 'Rp',
            'ILS' => '&#8362;',
            'IMP' => '&pound;',
            'INR' => '&#8377;',
            'IQD' => '&#x639;.&#x62f;',
            'IRR' => '&#xfdfc;',
            'IRT' => '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;',
            'ISK' => 'kr.',
            'JEP' => '&pound;',
            'JMD' => '&#36;',
            'JOD' => '&#x62f;.&#x627;',
            'JPY' => '&yen;',
            'KES' => 'KSh',
            'KGS' => '&#x441;&#x43e;&#x43c;',
            'KHR' => '&#x17db;',
            'KMF' => 'Fr',
            'KPW' => '&#x20a9;',
            'KRW' => '&#8361;',
            'KWD' => '&#x62f;.&#x643;',
            'KYD' => '&#36;',
            'KZT' => 'KZT',
            'LAK' => '&#8365;',
            'LBP' => '&#x644;.&#x644;',
            'LKR' => '&#xdbb;&#xdd4;',
            'LRD' => '&#36;',
            'LSL' => 'L',
            'LYD' => '&#x644;.&#x62f;',
            'MAD' => '&#x62f;.&#x645;.',
            'MDL' => 'MDL',
            'MGA' => 'Ar',
            'MKD' => '&#x434;&#x435;&#x43d;',
            'MMK' => 'Ks',
            'MNT' => '&#x20ae;',
            'MOP' => 'P',
            'MRO' => 'UM',
            'MUR' => '&#x20a8;',
            'MVR' => '.&#x783;',
            'MWK' => 'MK',
            'MXN' => '&#36;',
            'MYR' => '&#82;&#77;',
            'MZN' => 'MT',
            'NAD' => '&#36;',
            'NGN' => '&#8358;',
            'NIO' => 'C&#36;',
            'NOK' => '&#107;&#114;',
            'NPR' => '&#8360;',
            'NZD' => '&#36;',
            'OMR' => '&#x631;.&#x639;.',
            'PAB' => 'B/.',
            'PEN' => 'S/.',
            'PGK' => 'K',
            'PHP' => '&#8369;',
            'PKR' => '&#8360;',
            'PLN' => '&#122;&#322;',
            'PRB' => '&#x440;.',
            'PYG' => '&#8370;',
            'QAR' => '&#x631;.&#x642;',
            'RMB' => '&yen;',
            'RON' => 'lei',
            'RSD' => '&#x434;&#x438;&#x43d;.',
            'RUB' => '&#8381;',
            'RWF' => 'Fr',
            'SAR' => '&#x631;.&#x633;',
            'SBD' => '&#36;',
            'SCR' => '&#x20a8;',
            'SDG' => '&#x62c;.&#x633;.',
            'SEK' => '&#107;&#114;',
            'SGD' => '&#36;',
            'SHP' => '&pound;',
            'SLL' => 'Le',
            'SOS' => 'Sh',
            'SRD' => '&#36;',
            'SSP' => '&pound;',
            'STD' => 'Db',
            'SYP' => '&#x644;.&#x633;',
            'SZL' => 'L',
            'THB' => '&#3647;',
            'TJS' => '&#x405;&#x41c;',
            'TMT' => 'm',
            'TND' => '&#x62f;.&#x62a;',
            'TOP' => 'T&#36;',
            'TRY' => '&#8378;',
            'TTD' => '&#36;',
            'TWD' => '&#78;&#84;&#36;',
            'TZS' => 'Sh',
            'UAH' => '&#8372;',
            'UGX' => 'UGX',
            'USD' => '&#36;',
            'UYU' => '&#36;',
            'UZS' => 'UZS',
            'VEF' => 'Bs F',
            'VND' => '&#8363;',
            'VUV' => 'Vt',
            'WST' => 'T',
            'XAF' => 'Fr',
            'XCD' => '&#36;',
            'XOF' => 'Fr',
            'XPF' => 'Fr',
            'YER' => '&#xfdfc;',
            'ZAR' => '&#82;',
            'ZMW' => 'ZK',
        ];
        $currency_symbol = isset($symbols[$currency]) ? $symbols[$currency] : '';

        return $currency_symbol;
    }
}
if (! function_exists('paypal_ipn_verify')) {
    function paypal_ipn_verify()
    {
        $paypal_action_url = 'https://www.paypal.com/cgi-bin/webscr';
        if (get_option('enable_paypal_sandbox') == 1) {
            $paypal_action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }

        // STEP 1: read POST data
        // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
        // Instead, read raw POST data from the input stream.
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = [];
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // STEP 2: POST IPN data back to PayPal to validate
        $ch = curl_init($paypal_action_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close']);

        if (! ($res = curl_exec($ch))) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        // STEP 3: Inspect IPN validation result and act accordingly
        if (strcmp($res, 'VERIFIED') == 0) {
            return true;
        } elseif (strcmp($res, 'INVALID') == 0) {
            return false;
        }
    }
}

if (! function_exists('safe_output')) {
    function safe_output($text = null)
    {
        if ($text) {
            $text = strip_tags($text, '<h1><h2><h3><h4><h5><h6><p><br><ul><li><hr><a><abbr><address><b><blockquote><center><cite><code><del><i><ins><strong><sub><sup><time><u><img><iframe><link><nav><ol><table><caption><th><tr><td><thead><tbody><tfoot><col><colgroup><div><span>');

            $text = str_replace('javascript:', '', $text);
        }

        return $text;
    }
}

if (! function_exists('avatar_by_email')) {
    function avatar_by_email($email = '', $s = 40, $d = 'mm', $r = 'g', $img = false, $atts = [])
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";

        if ($img) {
            $url = '<img src="'.$url.'"';
            foreach ($atts as $key => $val) {
                $url .= ' '.$key.'="'.$val.'"';
            }
            $url .= ' />';
        }

        return $url;
    }
}

if (! function_exists('frontendLocalisedJson')) {
    function frontendLocalisedJson()
    {
        $json_array = [
            'time_remaining' => trans('app.time_remaining'),
        ];

        $json = \Psy\Util\Json::encode($json_array);

        return $json;
    }
}
