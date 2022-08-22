<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $querySearch = '';
        $queries = $request->query();
        if(isset($queries['searchQuery'])){
            $querySearch = $queries['searchQuery'];
            $articles = Article::with('category')->where('title', 'like', '%'.$querySearch.'%')->skip($queries['skip'])->take($queries['take'])->paginate($queries['take']);
        }

        $articles = Article::with('category')->skip($queries['skip'])->take($queries['take'])->paginate($queries['take']);

        foreach ($articles as $article) {
            $article->setAttribute('type', $article->category()->get()->first()->name);
        }

        return response(['data' => $articles]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $article = new Article();
        $article->title = $request->title;
        $article->texte = $request->texte;

        if($request->hasFile('image')){
            $article->image = 'storage/'.$request->image->store('storage/uploads','public');
        }else $article->image = '';

        $category = Category::where('name', 'like', $request->type)->first();
        $article->category()->associate($category)->save();


        return $article->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::with('category')->find($id);
        // $arr = $event;
        $article->setAttribute('type', $article->category()->get()->first()->name);

        // return array_push($arr, $event->category()->get()->first()->name);
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {

        $article = Article:: find($id)->first();
        $article->title = $request->title;
        $article->texte = $request->texte;
        if($request->hasFile('image')){
            unlink($article->image);
            $image = 'storage/'.$request->image->store('storage/uploads','public');
            return $article->update([
                'title' => $request->title,
                'texte' => $request->texte,
                'image' => $image
            ]);
        }
        return $article->update([
            'title' => $request->title,
            'texte' => $request->texte,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article:: find($id);
        unlink($article->image);
        $article->delete();
        return response(['message'=> 'delete correctly', 'status' => 200]);
    }
}
