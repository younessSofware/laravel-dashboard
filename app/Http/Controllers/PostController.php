<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = \App\Models\Post:: all();
        return view('posts.index', ['posts' => $posts]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->slug = $request->slug;

        if($request->hasFile('image')){
            $post->image = $request->image->store('storage/uploads','public');
        }else $post->image = '';
        $post->active = true;

        $post->save();
        return redirect()->route('posts.index');

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = \App\Models\Post:: find($id);
        //
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = \App\Models\Post::find($id);
        return view('posts.edit', ['post' => $post]);
        //
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
        $post = \App\Models\Post:: find($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->slug = $request->slug;

        if($request->hasFile('image')){
            unlink("storage/".$post->image);
            $post->image = $request->image->store('storage/uploads','public');
        }

        $post->save();
        return redirect()->route('posts.index');
        //
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = \App\Models\Post:: find($id);
        unlink("storage/".$post->image);
        $post->delete();
        return redirect()->route('posts.index');

        //
    }
}
