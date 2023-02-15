<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showCreatePost()
    {
        return view("createPost");
    }
    public function addNewPost(Request $request)
    {
        $incomingFields = $request->validate(['title' => 'required', 'body' => 'required']);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        // add user_id to the array
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/posts/$newPost->id")->with('successMessage', 'you have successfully create this post');
    }
    public function deletePost(Post $post)
    {
        // if (auth()->user()->cannot('delete', $post)) {
        //     return 'you cannot delete this post';
        // }
        $post->delete();
        return redirect('/profile/' . auth()->user()->username)->with('successMessage', "The Post Was Deleted!");
    }
    public function showEditPost(Post $post)
    {
        return view('edit-post', ['post' => $post]);
    }
    public function edditPost(Post $post, Request $request)
    {
        $incomingFields = $request->validate(['title' => 'required', 'body' => 'required']);


        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->title = $incomingFields['title']; // Update the post's attributes
        $post->body = $incomingFields['body'];

        $post->save(); // Save the post to the database
        // return redirect("/posts/" . $post->id)->with('successMessage', 'Post Updated!');
        return back()->with("successMessage", 'the post was updated');
    }

    public function showSinglePost(Post $post)
    {

        $post->body = Str::markdown($post->body);

        return view("single-post", ['post' => $post]);
    }
}
