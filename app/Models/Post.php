<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'slug', 'description', 'image_path', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * @param $res
     * @param $admin
     */
    public static function addExternalPost($res, $admin)
    {
        $newPost = new Post;
        $newPost->title = $res['title'];
        $newPost->slug = $res['title'];
        $newPost->description = $res['description'];
        $newPost->created_at = $res['publication_date'];
        $newPost->user_id = $admin->id;
        $newPost->save();
    }
}
