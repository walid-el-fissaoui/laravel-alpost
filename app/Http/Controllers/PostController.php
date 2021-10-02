<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use App\Models\Image;
use Illuminate\Filesystem\Cache as FilesystemCache;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('auth')->only(['create', 'edit', 'destroy', 'update', 'store']);
        $this->middleware('auth')->except(['index','show','all','archive']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index', [
            'posts' =>  Post::postWithUserCommentsTags()->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {
        return view('posts.index', [
            'posts' => Post::onlyTrashed()->withCount('comments')->get() ,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return view('posts.index', [
            'posts' => Post::withTrashed()->withCount('comments')->get() ,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** 60 for 60 seconds */
        /** 3600 for 1 hour */
        $postShow = Cache::remember("post-show-{$id}", 3600 , function () use($id) {
            return Post::with(['comments','tags', 'comments.user'])->findOrFail($id); 
        });
        return view('posts.show', [
            'post' => $postShow
        ]);
    }

    public function create()
    {
        // $this->authorize('create');
        // $this->authorize('create' , Post::class);
        return view('posts.create');
    }

    public function store(StorePost $request)
    {

        $hasFile = $request->hasFile('picture'); /** this request's method return true or false */
        

        $data = $request->only(['title', 'content']);
        $data['slug'] = Str::slug($data['title'], '-');
        $data['active'] = false;
        $data['user_id'] = $request->user()->id;
        $post = Post::create($data);

        if ($request->hasFile('picture'))
        {
            $path = $request->file('picture')->store('posts');
            $image = new Image(['path' => $path]);
            $post->image()->save($image);
        }

        // $this->authorize('create', $post);
        $request->session()->flash('status', 'post was created!!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function edit($id)
    {
        // $post = Post::find($id);
        $post = Post::findOrFail($id);

        $this->authorize("update" , $post);

        /** return 404 status not found page if the post not exist */
        return view('posts.edit', compact('post'));
        /** use compact or send a table of data ['post' => $post] */
    }

    public function update(StorePost $request, $id)
    {
        $post = Post::find($id);

        $this->authorize("update" , $post);

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->slug = Str::slug($request->input('title'), '-');
        $post->save();

        if ($request->hasFile('picture'))
        {
            $path = $request->file('picture')->store('posts');

            if($post->image)
            {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }
            else
            {
                $post->image()->save(Image::make(['path' => $path]));

                /** second method : */
                // $image = new Image(['path' => $path]);
                // $post->image()->save($image);
            }
            
        }        
        /** since the post is retreived from the database , so the save method will update the post instead of creating new one */
        $request->session()->flash('status', 'post was updated');
        return redirect()->route('posts.index');
    }

    public function destroy(Request $request, $id)
    {
        $post =  Post::findOrFail($id);
        $this->authorize("delete" , $post);
        $post->delete();
        $request->session()->flash('status', 'post was deleted !');
        return redirect()->route('posts.index');
    }

    public function restore($id)
    {
        
        $post = Post::onlyTrashed()->where('id',$id)->first();
        $this->authorize('restore', $post);
        $post->restore();
        return redirect()->route('posts.index');
        // return redirect()->back();
    }

    public function forcedelete($id)
    {
        $post = Post::onlyTrashed()->where('id',$id)->first();
        $this->authorize('forceDelete', $post);
        $post->forceDelete();
        return redirect()->route('posts.index');
    }
}
