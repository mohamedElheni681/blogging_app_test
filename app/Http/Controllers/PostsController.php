<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;


class PostsController extends Controller
{
 
    public function __construct()
    {
       $this->middleware('auth', ['except' => ['index', 'show']]);
       $this->middleware('can:update-post', ['only' => ['update']]);
       $this->middleware('can:delete-post', ['only' => ['destroy']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if(!$user){
            return redirect('/');
        }
        $posts = Post::where('user_id', $user->id)
            ->orderBy('created_at', $request->sort ? $request->sort : 'desc')
            ->paginate(1)
            ->withQueryString();

        $title = __('post.your_posts');

        return view('blog.index', compact('posts', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * @param StorePostRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StorePostRequest $request)
    {
        Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
            'user_id' => auth()->user()->id
        ]);

        toastr(__('post.post_created_successfully'), 'success', __('post.post_creation'));

        return redirect('/blog');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return view('blog.show')
            ->with('post', Post::where('slug', $slug)->first());
    }

    /**
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        return view('blog.edit')
            ->with('post', Post::where('id', $id)->first());
    }

    /**
     * @param UpdatePostRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdatePostRequest $request, $id)
    {
        Post::where('id', $id)
            ->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
                'user_id' => auth()->user()->id
            ]);


        toastr(__('post.post_updated_successfully'), 'success', __('post.post_updation'));

        return redirect('/blog');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id);
        $post->delete();

        toastr(__('post.post_deleted_successfully'), 'success', __('post.post_deletion'));

        return redirect('/blog');
    }

}

