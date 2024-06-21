<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', auth()->id())->get();
        return view('dashboard', compact('events'));
    }

    public function allEvents()
    {
        $events = Event::all();
        return view('dashboard', compact('events'));
    }

    public function subscribedEvents()
    {
        $events = Auth::user()->events;
        return view('dashboard', compact('events'));
    }

    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'image' => 'nullable|image',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/event_images');
            $imagePath = Storage::url($imagePath);
        }

        // Create event
        Event::create([
            'image_url' => $imagePath,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard');
    }

    public function update(Request $request, Event $event)
    {
        // Validate request data
        $request->validate([
            'image' => 'nullable|image',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image_url) {
                Storage::delete($event->image_url);
            }
            $imagePath = $request->file('image')->store('public/event_images');
            $event->image_url = Storage::url($imagePath);
        }

        // Update event data
        $event->title = $request->title;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->save();

        return redirect()->route('dashboard');
    }

    public function destroy(Event $event)
    {
        // Delete the event's image if exists
        if ($event->image_url) {
            Storage::delete($event->image_url);
        }
        
        // Delete the event
        $event->delete();

        return redirect()->route('dashboard');
    }
}
