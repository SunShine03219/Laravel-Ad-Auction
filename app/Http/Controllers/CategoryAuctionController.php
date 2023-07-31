<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\Favorite;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryAuctionController extends Controller
{
    public function index($category)
    {
        $favorites = [];
        $user = Auth::user();
        $categoryLevel = explode('/', $category);
        $lastLevel = '/'.array_values($categoryLevel)[1];
        
        if(sizeof($categoryLevel) > 2)  {
            $lastLevel = '/'.array_values($categoryLevel)[1].'/'.array_values($categoryLevel)[2];
        }
        
        // $categorySlug = Category::where('category_slug', $lastLevel)->first();
        // $topCategory = Category::where('parent_id', $categorySlug->id)->get();
        
        $topCategories = Category::select('*')
        ->selectSub(function ($query) use ($lastLevel) {
            $query->from('ads')
            // ->where('ad_close_timestamp', '<', Carbon::now()->addDays(3))
            // ->where('ad_start_timestamp', '>', Carbon::now())
            ->where('quan', '>', 0)
            ->where('cat1_slugpath', 'LIKE', $lastLevel.'%')
            ->whereRaw("SUBSTRING_INDEX(`ads`.`cat1_slugpath`, '/', 3) = `categories`.`slug_path`")
            ->orWhere('cat2_slugpath', 'LIKE', $lastLevel.'%')
            ->whereRaw("SUBSTRING_INDEX(`ads`.`cat2_slugpath`, '/', 3) = `categories`.`slug_path`")
            ->select(DB::raw('COUNT(*)'));
        }, 'ad_count')
        ->having('ad_count', '>', 0)
        ->get();

        if(sizeof($categoryLevel) > 2) {
            $topCategories[0]['category_name'] = 'Other';
        }
        
        if ($user) {
            $user_id = $user->id;
            $favorites = Favorite::where('user_id', $user_id)->orderBy('ad_id')->get('ad_id');

            $premium_ads = Ad::activePremium()
                ->select("ads.*", "f.id as fid")
                ->with('category', 'city', 'state', 'country', 'sub_category')
                ->leftJoin(DB::raw("(SELECT * FROM favorites WHERE user_id=$user->id) f"), "ads.id", "=", "f.ad_id")
                // ->where('ad_close_timestamp', '<', Carbon::now()->addDays(3))
                // ->where('ad_start_timestamp', '>', Carbon::now())
                ->where('quan', '>', 0)
                ->where(function ($query) use ($lastLevel) {
                    $query->where('cat1_slugpath', 'LIKE', '%' . $lastLevel . '%')
                        ->orWhere('cat2_slugpath', 'LIKE', '%' . $lastLevel . '%');
                })
                ->orderBy('id', 'desc')
                ->get();

            $regular_ads = Ad::activeRegular()
                ->select("ads.*", "f.id as fid")
                ->with('category', 'city', 'state', 'country', 'sub_category')
                ->leftJoin(DB::raw("(SELECT * FROM favorites WHERE user_id=$user->id) f"), "ads.id", "=", "f.ad_id")
                // ->where('ad_close_timestamp', '<', Carbon::now()->addDays(3))
                // ->where('ad_start_timestamp', '>', Carbon::now())
                ->where('quan', '>', 0)
                ->where(function ($query) use ($lastLevel) {
                    $query->where('cat1_slugpath', 'LIKE', '%' . $lastLevel . '%')
                        ->orWhere('cat2_slugpath', 'LIKE', '%' . $lastLevel . '%');
                })
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $premium_ads = Ad::activePremium()
                ->with('category', 'city', 'state', 'country', 'sub_category')
                // ->where('ad_close_timestamp', '<', Carbon::now()->addDays(3))
                // ->where('ad_start_timestamp', '>', Carbon::now())
                ->where('quan', '>', 0)
                ->where(function ($query) use ($lastLevel) {
                    $query->where('cat1_slugpath', 'LIKE', '%' . $lastLevel . '%')
                        ->orWhere('cat2_slugpath', 'LIKE', '%' . $lastLevel . '%');
                    // $query->where('cat1_slugpath', 'LIKE', '%' . $categorySlug->slug_path . '%')
                    //     ->orWhere('cat2_slugpath', 'LIKE', '%' . $categorySlug->slug_path . '%');
                })
                ->orderBy('id', 'desc')
                ->get();

            $regular_ads = Ad::activeRegular()
                ->with('category', 'city', 'state', 'country', 'sub_category')
                // ->where('ad_close_timestamp', '<', Carbon::now()->addDays(3))
                // ->where('ad_start_timestamp', '>', Carbon::now())
                ->where('quan', '>', 0)
                ->where(function ($query) use ($lastLevel) {
                    $query->where('cat1_slugpath', 'LIKE', '%' . $lastLevel . '%')
                        ->orWhere('cat2_slugpath', 'LIKE', '%' . $lastLevel . '%');
                    // $query->where('cat1_slugpath', 'LIKE', '%' . $categorySlug->slug_path . '%')
                    //     ->orWhere('cat2_slugpath', 'LIKE', '%' . $categorySlug->slug_path . '%');
                })
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('category.category_auction', compact('topCategories', 'premium_ads',  'regular_ads', 'favorites'));
    }
}
