<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Event;

class CommentController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'content' => 'required|max:500',
        ]);

        Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return redirect()->route('dashboard.all');
    }

    public function index()
    {
        $events = Event::with('comments.user')->get();
        return view('dashboard', compact('events'));
    }
}

