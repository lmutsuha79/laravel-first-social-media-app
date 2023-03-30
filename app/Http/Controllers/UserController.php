<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function showCorrectHomePage()
    {
        if (auth()->check()) {
            return view("homePage");
        }
        return view("homePageGuest");
    }
    private function getProfileData($user)
    {
        $currentlyFollowing = Follow::where([
            ['user_id', '=', auth()->user()->id],
            ['followed_user', '=', $user->id]
        ])->count();
        $numberOfFollowers = $user->followers->count();
        $numberOfPosts = $user->posts->count();
        $numberOfFollowing = $user->following->count();
        View::share(
            'sharedData',
            [
                'avatar' => $user->avatar,
                'username' => $user->username,
                'numberOfFollowers' => $numberOfFollowers,
                'numberOfFollowing' => $numberOfFollowing,
                'currentlyFollowing' => $currentlyFollowing,
                'numberOfPosts' => $numberOfPosts
            ]
        );
    }
    public function showProfile(User $user)
    {
        $this->getProfileData($user);
        $posts = $user->posts()->latest()->select('title', 'id', 'created_at')->get();


        return view('profile-posts', ['posts' => $posts]);
    }
    public function showProfileFollowers(User $user)
    {
        $this->getProfileData($user);
        $followers = $user->followers()->latest()->get();
        return view('profile-followers', ['followers' => $followers]);
    }


    public function showProfileFollowing(User $user)
    {
        $this->getProfileData($user);
        $followingList = $user->following()->latest()->get();
        return view('profile-following', ['following' => $followingList]);
    }

    public function showUploadAvatar()
    {
        return view('manage-avatar');
    }
    public function storeAvatar(Request $request)
    {
        $user = auth()->user();
        $request->validate(['avatar' => "required|image|max:3000"]);
        $image = $request->file("avatar");


        $imageData = Image::make($image)->resize("100", "100", function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode("jpg");

        $imageName = $user->username . '_' . 'avatar' . uniqid() . '.jpg';
        Storage::put("public/avatars/$imageName", $imageData);
        $oldAvatar = $user->avatar;
        $user->avatar = $imageName;
        // @ts-ignore
        $user->save();

        if ($oldAvatar != "/fallback-avatar.jpg") {

            Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
            // return " yes =+> $oldAvatar";
        }
        // return "no";

        // $user = User::find(auth()->user()->id);
        // $user->avatar = $imageName;
        // $user->save();


        return back()->with("successMessage", "you are successfully update your profile image");
    }
    public function login(Request $request)
    {
        $incomingFields = $request->validate(['loginusername' => "required", 'loginpassword' => "required"]);

        $loginusername = $incomingFields['loginusername'];
        $loginpassword = $incomingFields['loginpassword'];

        if (auth()->attempt(['username' => $loginusername, 'password' => $loginpassword], $remeber = TRUE)) {
            $request->session()->regenerate();
            return redirect('/')->with('successMessage', 'you are loged in');
        } else {
            return redirect('/')->with('failMessage', 'incorrect login information try again');
        }
    }
    public function logOut()
    {
        auth()->logout();
        return redirect('/')->with('successMessage', 'you are loged out');
    }
    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'username' => ["required", "min:3", "max:20", Rule::unique("users", "username")],
            "email" => ["required", "email", Rule::unique("users", "email")],
            "password" => ["required", "min:5", "confirmed"],

        ]);
        // hash the password befor send it to the User model
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/')->with('successMessage', 'you are now successfully register');
    }
}
