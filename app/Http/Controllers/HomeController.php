<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Contact_query;
use App\Models\User;
use App\Models\Favorite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {

        $favorites = [];
        $user = Auth::user();
        // $topCategories = Category::select(DB::raw('COUNT(*)'))->where('slug_path', '=', DB::raw("SUBSTRING_INDEX('/pets-animals/cats/cats-for-sale', '/', 2)"))->get();
        $topCategories = Category::select('*')
            ->selectSub(function ($query) {
                $query->from('ads')
                    ->whereRaw("SUBSTRING_INDEX(`ads`.`cat1_slugpath`, '/', 2) = `categories`.`slug_path`")
                    ->orwhereRaw("SUBSTRING_INDEX(`ads`.`cat2_slugpath`, '/', 2) = `categories`.`slug_path`")
                    ->select(DB::raw('COUNT(*)'));
            }, 'ad_count')
            ->where('category_type', 'auction')
            // ->whereNull('parent_id')
            ->having('ad_count', '>', 0)
            ->get();
            
            
        $limit_regular_ads = get_option('number_of_free_ads_in_home');
        $limit_premium_ads = get_option('number_of_premium_ads_in_home');
        
        if($user){
            $user_id = $user->id;
            $favorites = Favorite::where('user_id', $user_id)->orderBy('ad_id')->get('ad_id');

            $regular_ads = Ad::activeRegular()
            ->select("ads.*", "f.id as fid")
            ->with('category', 'city', 'state', 'country', 'sub_category')
            ->leftJoin(DB::raw("(SELECT * FROM favorites WHERE user_id=$user->id) f"), "ads.id", "=", "f.ad_id")
            // ->where('ad_close_timestamp', '<', Carbon::now()->addDays(3))
            // ->where('ad_start_timestamp', '>', Carbon::now())
            ->where('quan', '>', 0)
            ->limit($limit_regular_ads)
            ->orderBy('id', 'desc')
            ->get();
            $premium_ads = Ad::activePremium()
            ->select("ads.*", "f.id as fid")
            ->with('category', 'city', 'state', 'country', 'sub_category')
            ->leftJoin(DB::raw("(SELECT * FROM favorites WHERE user_id=$user->id) f"), "ads.id", "=", "f.ad_id")
            // ->where('ad_close_timestamp', '<', Carbon::now()->addDays(3))
            // ->where('ad_start_timestamp', '>', Carbon::now())
            ->where('quan', '>', 0)
            ->limit($limit_premium_ads)
            ->orderBy('id', 'desc')
            ->get();
        }else {
            $regular_ads = Ad::activeRegular()
            ->with('category', 'city', 'state', 'country', 'sub_category')
            // ->where('ad_close_timestamp', '<', Carbon::now()->addDays(3))
            // ->where('ad_start_timestamp', '>', Carbon::now())
            ->where('quan', '>', 0)
            ->limit($limit_regular_ads)
            ->orderBy('id', 'desc')
            ->get();
            
            $premium_ads = Ad::activePremium()
            ->with('category', 'city', 'state', 'country', 'sub_category')
            // ->where('ad_close_timestamp', '<', Carbon::now()->addDays(3))
            // ->where('ad_start_timestamp', '>', Carbon::now())
            ->where('quan', '>', 0)
            ->limit($limit_premium_ads)
            ->orderBy('id', 'desc')
            ->get();
        }   
       
        $total_ads_count = Ad::active()->count();
        $user_count = User::count();
        // dd($topCategories);

        return view('index', compact( 'topCategories','regular_ads', 'premium_ads', 'total_ads_count', 'user_count', 'favorites'));
    }

    public function contactUs()
    {
        $title = trans('app.contact_us');

        return view('contact_us', compact('title'));
    }

    public function contactUsPost(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ];
        $this->validate($request, $rules);
        Contact_query::create(array_only($request->input(), ['name', 'email', 'message']));

        return redirect()->back()->with('success', trans('app.your_message_has_been_sent'));
    }

    public function contactMessages()
    {
        $title = trans('app.contact_messages');
        $contact_messages = Contact_query::orderBy('id', 'desc')->paginate(20);

        return view('admin.contact_messages', compact('title', 'contact_messages'));
    }

    /**
     * Switch Language
     */
    public function switchLang($lang)
    {
        session(['lang' => $lang]);

        return back();
    }

    /**
     * Reset Database
     */
    public function resetDatabase()
    {
        $database_location = base_path('database-backup/classified.sql');
        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file($database_location);
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                DB::statement($templine);
                // Reset temp variable to empty
                $templine = '';
            }
        }
        $now_time = date('Y-m-d H:m:s');
        DB::table('ads')->update(['created_at' => $now_time, 'updated_at' => $now_time]);
    }

    public function clearCache()
    {
        Artisan::call('debugbar:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        if (function_exists('exec')) {
            exec('rm ' . storage_path('logs/*'));
        }
        $this->rrmdir(storage_path('logs/'));

        return redirect(route('home'));
    }

    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($dir . '/' . $object)) {
                        $this->rrmdir($dir . '/' . $object);
                    } else {
                        unlink($dir . '/' . $object);
                    }
                }
            }
            //rmdir($dir);
        }
    }
}
