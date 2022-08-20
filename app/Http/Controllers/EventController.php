<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Category;
use App\Models\event;
use Illuminate\Http\Request;

class EventController extends Controller
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
            $events = event::with('category')->where('name', 'like', '%'.$querySearch.'%')->skip($queries['skip'])->take($queries['take'])->paginate($queries['take']);
        }
        else $events = event::with('category')->skip($queries['skip'])->take($queries['take'])->paginate($queries['take']);

        foreach ($events as $event) {
            $event->setAttribute('type', $event->category()->get()->first()->name);
        }
        return response(['data' =>  $events]);
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
    public function store(EventRequest $request)
    {
        $event = new Event($request->all());
        $category = Category::where('name', 'like', $request->type)->first();
        $event->category()->associate($category)->save();
        // $comment->post()->associate($post)->save()
        return $event->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $event = event::with('category')->find($id);
        // $arr = $event;
        $event->setAttribute('type', $event->category()->get()->first()->name);

        // return array_push($arr, $event->category()->get()->first()->name);
        return $event;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = event::find($id);
        return response(['Update correctly', $event->update($request->all())], 201);
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
        //
        $event = event:: find($id);
        $event->delete();
        return response(['message'=> 'delete correctly', 'status' => 200]);
    }
}
