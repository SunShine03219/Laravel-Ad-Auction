<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_Category extends Model
{
    protected $table = 'categories';

    public function parentCategory()
    {
        return $this->belongsTo(Category::class);
    }

    public function product_count()
    {
        return $this->hasMany(Ad::class, 'sub_category_id')->whereStatus('1')->count();
    }
}
