<?php

namespace App\Models;

use App\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $guarded = [];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function sub_categories()
    {
        return $this->hasMany('App\Models\Sub_Category')->orderBy('category_name', 'asc');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function product_count()
    {
        return $this->hasMany(Ad::class)->whereStatus('1')->count();
    }

    public function parent() : BelongsTo {
        return $this->belongsTo(Category::class, 'parent_id'); //get parent category
    }
    public function children() : HasMany {
        return $this->hasMany(Category::class, 'parent_id'); //get all subs. NOT RECURSIVE
    }
}
