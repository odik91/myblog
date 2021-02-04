<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "View Post";
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('admin.post.index', compact('title', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Post';
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.post.create', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'category' => 'required',
            'subcategory' => 'required',
            'picture' => 'mimes:jpg,jpeg,png',
            'article' => 'required|min:10'
        ]);

        // $data = $request->all();
        $image = '';

        if ($request->hasFile('picture')) {
            $image = $request['picture']->hashName();
            $request['picture']->move(public_path('post'), $image);
        }

        $data['title'] = $request['title'];
        $data['slug'] = Str::slug($request['title']);
        $data['category_id'] = $request['category'];
        $data['sub_category_id'] = $request['subcategory'];
        $data['content'] = $request['article'];
        $data['image'] = $image;
        $data['author'] = 1;
        $data['year'] = date("Y");
        $data['month'] = date("m");
        Post::create($data);

        return redirect()->back()->with('message', "Post $request->title created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $title = "View Post";

        return view('admin.post.view', compact('post', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $title = 'Edit ' . $post['title'] ;
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.post.edit', compact('post', 'title', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:3|unique:posts,title,' . $id,
            'category' => 'required',
            'subcategory' => 'required',
            'picture' => 'mimes:jpg,jpeg,png',
            'article' => 'required|min:10'
        ]);
        
        $post = Post::find($id);
        $image = $post['image'];

        if ($request->hasFile('picture')) {
            unlink(public_path("post/{$post['image']}"));
            $image = $request['picture']->hashName();
            $request['picture']->move(public_path('post'), $image);
        }

        $data['title'] = $request['title'];
        $data['slug'] = Str::slug($request['title']);
        $data['category_id'] = $request['category'];
        $data['sub_category_id'] = $request['subcategory'];
        $data['content'] = $request['article'];
        $data['image'] = $image;
        $data['author'] = 1;

        $post->update($data);
        return redirect()->route('posts.index')->with('message', "Post $request->title updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return redirect()->back()->with('message', 'Post moved to trash');
    }
    
    public function loadSubcategory(Request $request, $id) {
        $subcategory = SubCategory::where('category_id', $id)->pluck('subname', 'id');
        return response()->json($subcategory);
    }    

    public function ajaxUploadImage(Request $request) {
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,png'
        ]);
        // return $request['image']->hashName();
        // dd($request['image']);
        $imageName = $request['image']->hashName();
        $request->image->move(public_path('post'), $imageName);
        // return "/post/$imageName";
        return asset("post/$imageName");
    }

    public function ajaxDeleteImage(Request $request) {
        $src = $request['src'];
        $charln = strlen($request['src']);
        $pathln = strlen(public_path('post')) - 7;
        $file_name = substr($request['src'], $pathln);
        // return $file_name;
        if (unlink(public_path("post/{$file_name}"))) {
            return 'image deleted';
        } else {
            return 'somethinng went wrong';
        }
    }

    public function trash() {
        $title = "Post trash";
        $posts = Post::onlyTrashed()->get();
        return view('admin.post.trash', compact('title', 'posts'));
    }

    public function trashRestore($id) {
        $posts = Post::onlyTrashed()->where('id', $id)->get();
        $title = '';
        foreach ($posts as $post) {
            $title = $post['title'];
        }
        Post::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back()->with('message', "Post restore $title successfully");
    }

    public function destroyItem($id) {
        $posts = Post::onlyTrashed()->where('id', $id)->get();
        $image = '';
        foreach ($posts as $post) {
            $image = $post['image'];
        }
        unlink(public_path("post/{$image}"));
        Post::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->back()->with('message', 'Post has gone forever 😭');
    }

    public function uploadImage(Request $request) {
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,png'
        ]);

        // $imageName = $request['image']->hashName();
        $imageName = $request['image']->hashName();

        // $request->image->move(public_path('post'), $imageName);

        return Response()->json($imageName);
    }

    public function ajaxTest(Request $request) {
        $output = $request['testajax'];
        return response()->json($output);
    }
}
