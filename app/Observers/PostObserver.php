<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostNotification;

class PostObserver
{
    public function created(Post $post)
    {
        $author = $post->user;
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new PostNotification($post, $author));
        }
    }
}
