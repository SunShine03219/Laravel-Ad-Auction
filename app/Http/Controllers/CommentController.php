<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CommentController extends Controller
{
    public function index()
    {
        $title = trans('app.comments');

        $user = Auth::user();
        if ($user->is_admin()) {
            $comments = Comment::orderBy('id', 'desc')->paginate(50);
        } else {
            //Get user specific comments
            $get_ad_ids = $user->ads->pluck('id')->toArray();
            $comments = Comment::whereIn('ad_id', $get_ad_ids)->orderBy('id', 'desc')->paginate(50);
        }

        return view('admin.comments', compact('title', 'comments'));
    }

    public function postComments(Request $request, $id)
    {
        $rules = [
            'comment' => 'required',
        ];
        $user_id = 0;

        $author_name = $request->author_name;
        $author_email = $request->author_email;
        if (! Auth::check()) {
            $rules['author_name'] = 'required';
            $rules['author_email'] = 'required';
        } else {
            $user = Auth::user();
            $user_id = $user->id;
            $author_name = $user->name;
            $author_email = $user->email;
        }
        $this->validate($request, $rules);

        $ip = $request->ip();
        $comment_id = $request->comment_id;
        if (! $comment_id) {
            $comment_id = 0;
        }

        //Auto approve if this ad owner
        $approved = 0;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $ad = Ad::find($id);
            if ($user_id == $ad->user_id) {
                $approved = 1;
            }
        } else {
            $request->session()->flash('success', trans('app.comment_posted'));
        }

        $data = [
            'user_id' => $user_id,
            'ad_id' => $id,
            'comment_id' => $comment_id,
            'author_name' => $author_name,
            'author_email' => $author_email,
            'author_ip' => $ip,
            'comment' => $request->comment,
            'approved' => $approved,
        ];

        //If it reply, make it approve
        if ($comment_id) {
            $data['approved'] = 1;
        }
        $post_comment = Comment::create($data);

        $back_url = URL::previous().'#comment-'.$post_comment->id;

        return redirect($back_url);
    }

    public function commentAction(Request $request)
    {
        $user = Auth::user();

        //Preventing unauthorised action
        $comment = Comment::find($request->comment_id);
        $comment_ad = Ad::find($comment->ad_id);

        if ($user->id != $comment_ad->user_id && ! $user->is_admin()) {
            return ['success' => false];
        }

        switch ($request->action) {
            case 'approve':
                $comment->approved = 1;
                $comment->save();
                break;

            case 'trash':
                $comment->delete();
                break;
        }

        return ['success' => 1];
    }
}
