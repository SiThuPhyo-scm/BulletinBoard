<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'status',
        'create_user_id',
        'updated_user_id',
        'deleted_user_id',
        'deleted_at',
    ];

    /**
     * Get the user that owns the post.
     */
    public function createuser()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }

    /**
     * Get the user Update post
     */
    public function updateuser()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
