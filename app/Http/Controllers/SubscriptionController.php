<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function subscribe(Event $event)
    {
        $user = auth()->user();

        // Check if the user is already subscribed to the event
        if ($user->events()->where('events.id', $event->id)->exists()) {
            return redirect()->route('dashboard');
        }

        $user->events()->attach($event);

        return redirect()->route('dashboard.all');
    }

    public function unsubscribe(Event $event)
    {
        $user = auth()->user();

        // Check if the user is subscribed to the event
        if (!$user->events()->where('events.id', $event->id)->exists()) {
            return redirect()->route('dashboard');
        }

        $user->events()->detach($event);

        return redirect()->route('dashboard.all');
    }
}
