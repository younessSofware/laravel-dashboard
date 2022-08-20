<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $querySearch = '';
        $queries = $request->query();
        if(isset($queries['searchQuery'])){
            $querySearch = $queries['searchQuery'];
            return response(['data' => Category::where('name', 'like', '%'.$querySearch.'%')->skip($queries['skip'])->take($queries['take'])->paginate($queries['take'])]);
        }
        return response(['data' => Category::skip($queries['skip'])->take($queries['take'])->paginate($queries['take'])]);
        // return Category::where('type', 'like', '%'.$req->type.'%')->get();
    }

    public function categoriesByType(Request $req)
    {
        if($req->type == 0) return Category::where('type', 'like', '%'.'حدث'.'%')->get();
        if($req->type == 1) return Category::where('type', 'like', '%'.'مقال'.'%')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        return Category::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Category::find($id);
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
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        return $category->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category :: find($id);
        $category->delete();
        return response(['message'=> 'delete correctly', 'status' => 200]);
    }
}
