<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //* Get All Post
    public function index()
    {
        $posts = Post::with('user')->get();

        $res['status'] = 'success';
        $res['message'] = 'posts was fetched';
        $res['count'] = $posts->count();
        $res['data'] = $posts;

        return response($res);
    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image'
        ]);

        if ($validate->fails()) {
            $res['status'] = 'failed';
            $res['message'] = 'posts not created';
            $res['error'] = $validate->errors();
            $res['data'] = null;

            return response($res);
        }


        $post = new Post;
        $post->users_id = Auth::user()->id;
        $post->title = $request->title;
        $post->description = $request->description;

        if (!$request->hasFile('image')) {
            $res['status'] = 'failed';
            $res['message'] = 'posts not created';
            $res['error'] = 'please choose your post image';
            $res['data'] = null;

            return response($res);
        }
        $file = $request->file('image');
        $imageName = time() . '-' . $file->getClientOriginalName();
        $fileName =  str_replace('', '-', $imageName);

        $path = 'uploads/post/';
        $file->move($path, $fileName);

        //* Save Post
        $post->image = $path . $fileName;
        $post->save();

        $users = User::all();

        $data = [
            'title' => 'New Post',
            'userName' => 'Amanudin',
            'url' => ''
        ];
        foreach ($users as $user) {
            if ($user->email != Auth::user()->email) {
                Mail::to($user->email)->send(new SendMail(['title' => 'New Post', 'userName' => Auth::user()->name, 'url' => 'http://localhost:8000']));
            }
        };


        event(new \App\Events\PostNotification(Auth::user()->name, $post->image));

        //* Response
        $newPost = Post::whereId($post->id)->with('user')->first();
        $res['status'] = 'success';
        $res['message'] = 'posts was created';
        $res['data'] = $newPost;

        return response($res);
    }
}
