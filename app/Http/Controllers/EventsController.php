<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventsController extends Controller
{
    /**
     * Create a new EventsController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = auth()->user();
        return response()->json(['events' => $user->events], 200);
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest();
        $data['user_id'] = auth()->user()->id;
        Event::create($data);
    	return response()->json(['message' => 'Event Created'], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateRequest();

        $event = Event::find($id);
        if($event->user_id != auth()->user()->id){
            $userString = $event->user_id . ' = ' . auth()->user()->id;
            return response()->json(['message' => 'You cant edit this event', 'user' => $userString], 403);            
        }   

        $event->update($data);
        return response()->json(['message' => 'Event Updated'], 200);
    }

    public function validateRequest()
    {
        $thing = request()->validate([
            'tour_id' => 'nullable',
            'date' => 'required|date',
            'time' => 'nullable',
            'set_length' => 'required|integer',
            'venue_id' => 'required',
            'rider' => 'nullable',
            'pay' => 'required'
        ]);

        return $thing;
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if($event->user_id != auth()->user()->id){
            return response()->json(['message' => 'You dont own this events'], 403);
        }

        Event::destroy($id);
        return response()->json(['message' => 'Event Removed'], 200);
    }
}

