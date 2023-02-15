<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function showCorrectHomePage()
    {
        if (auth()->check()) {
            return view("homePage");
        }
        return view("homePageGuest");
    }
    public function showProfile(User $user)
    {
        $posts = $user->posts()->latest()->select('title', 'id', 'created_at')->get();

        return view('profile-posts', ['username' => $user->username, 'posts' => $posts]);
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
