<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::orderBy('created_at', $request->sort ? $request->sort : 'desc')
            ->paginate(1)
            ->withQueryString();

        $title = __('post.blog_posts');

        return view('blog.index', compact('posts', 'title'));
    }


}
