<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Post::latest()->get();
        if (!auth()->user()->is_admin) {
            $data = Post::where('user_id', auth()->user()->id)->latest()->get();
        }

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addColumn('category', function (Post $post) {
                    return $post->category->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="/dashboard/posts/' . $row->slug . '" class="badge bg-info" style="text-decoration: none;">Show</a><br>
                    <a href="/dashboard/posts/' . $row->slug . '/edit" class="badge bg-warning" style="text-decoration: none;">Edit</a><br>
                                <a href="/dashboard/posts/' . $row->slug . '" class="badge bg-danger" style="text-decoration: none;" data-confirm-delete="true">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['category', 'action'])
                ->addIndexColumn()
                ->make(true);
        }

        $title = 'Delete Post!';
        $text = 'Are you sure you want to delete this post?';
        confirmDelete($title, $text);

        return view('dashboard.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            'image' => 'image|file|max:5120',
            'body' => 'required'
        ]);

        if ($request->file('image')) {
            $validatedData["image"] = $request->file('image')->store('public/post-images');
        }

        $validatedData["user_id"] = auth()->user()->id;
        $validatedData["excerpt"] = Str::limit(strip_tags($request->body), 200);

        Post::create($validatedData);
        return redirect('/dashboard/posts')->with('success', 'New post has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (!auth()->user()->is_admin) {
            if ($post->author->id !== auth()->user()->id) {
                abort(403);
            }
        }

        $title = 'Delete Post!';
        $text = 'Are you sure you want to delete this post?';
        confirmDelete($title, $text);

        return view('dashboard.posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (!auth()->user()->is_admin) {
            if ($post->author->id !== auth()->user()->id) {
                abort(403);
            }
        }

        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:5120',
            'body' => 'required'
        ];

        if ($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData["image"] = $request->file('image')->store('/public/post-images');
        }

        $validatedData["user_id"] = auth()->user()->id;
        $validatedData["excerpt"] = Str::limit(strip_tags($request->body), 200);

        Post::where('id', $post->id)
            ->update($validatedData);
        return redirect('/dashboard/posts')->with('success', 'Post has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }

        Post::destroy($post->id);
        return redirect('/dashboard/posts')->with('success', 'New post has been deleted');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
