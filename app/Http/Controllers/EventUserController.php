<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Category;
use App\Models\event;
use App\Models\User;
use Illuminate\Http\Request;

class EventUserController extends Controller
{
    public function index(Request $request, $id){
        $user = User::find($id);

        $querySearch = '';
        $queries = $request->query();

        if(isset($queries['searchQuery'])){
            $querySearch = $queries['searchQuery'];
            $events = $user->events()->with('category')->where('name', 'like', '%'.$querySearch.'%')->skip($queries['skip'])->take($queries['take'])->paginate($queries['take']);
        }
        else $events = $user->events()->with('category')->skip($queries['skip'])->take($queries['take'])->paginate($queries['take']);

        foreach ($events as $event) {
            $event->setAttribute('type', $event->category()->get()->first()->name);
        }
        return response(['data' =>  $events]);
    }

    public function store(EventRequest $request, $id){
        $user = User::find($id);
        $event = new Event($request->all());
        $category = Category::where('name', 'like', $request->type)->first();
        $event->category()->associate($category)->save();
        $event->users()->attach($user);
        return $event;

    }

    public function destroy($user_id, $event_id){
        $event = event::find($event_id);
        $event->users()->detach($user_id);
        $user = event::find($user_id);
        $event->delete();
        return response(['message'=> 'delete correctly', 'status' => 200]);

    }





}
