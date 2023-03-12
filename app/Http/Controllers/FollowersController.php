<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function addFollow(User $user)
    {
        // you cannot follow your self:
        if ($user->id == auth()->user()->id) {
            return back()->with("failMessage", "you cannot follow yoursef");
        }
        // you cannot follow someone you're already  following

        $check_if_exist = Follow::where([
            ['user_id', '=', auth()->user()->id],
            ['followed_user', '=', $user->id]
        ])->count();

        if ($check_if_exist) {
            return back()->with("failMessage", "you're already following" . " " . $user->username);
        }


        $new_follow = new Follow;
        $new_follow->user_id = auth()->user()->id;
        $new_follow->followed_user = $user->id;
        $new_follow->save();
        return back()->with("successMessage", "you are now following" . " " . $user->username);
    }
    public function removeFollow(User $user)
    {
        // you cannot unfollow your self 
        if ($user->id == auth()->user()->id) {
            return back()->with("failMessage", "you cannot follow yoursef");
        }
        // you cannot unfollow a user that you are not following

        $following_row = Follow::where([
            ['user_id', '=', auth()->user()->id],
            ['followed_user', '=', $user->id]
        ]);
        if (!$following_row->count()) {
            return back()->with('failMessage', "you cannot unfollow someone you don't actually following");
        }


        $following_row->delete();

        return back()->with("successMessage", "you unfollow $user->username");
    }
}
