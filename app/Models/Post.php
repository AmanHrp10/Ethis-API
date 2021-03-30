<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = ['users_id', 'title', 'description', 'image'];

    protected $hidden = ['users_id'];

    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'users_id');
    }
}
