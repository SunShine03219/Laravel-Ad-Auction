<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function scopeApproved($query)
    {
        return $query->whereApproved('1');
    }

    public function scopeParent($query)
    {
        return $query->whereCommentId(0);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function childs_approved()
    {
        return $this->hasMany(ChildComment::class, 'comment_id', 'id')->whereApproved('1')->orderBy('id', 'desc');
    }

    public function created_at_datetime()
    {
        $created_date_time = $this->created_at->timezone(get_option('default_timezone'))->format(get_option('date_format_custom').' '.get_option('time_format_custom'));

        return $created_date_time;
    }

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
