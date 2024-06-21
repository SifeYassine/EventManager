<x-app-layout>
    <link rel="stylesheet" href="https://temp.staticsave.com/667b93147dbe5.css">
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mt-4">
                <a href="{{ route('dashboard.all') }}" class="btn btn-primary">All Events</a>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Created Events</a>
                <a href="{{ route('dashboard.subscribed') }}" class="btn btn-primary">Subscribed Events</a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createEventModal">
                    Create Event
                </button>
            </div>

            @if (session('status'))
                <div class="alert alert-success mt-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mt-4">
                <div class="row">
                    @foreach ($events as $event)
                        <div class="col-md-4 mb-4">
                            <div class="card event-card">
                                @if ($event->image_url)
                                    <img src="{{ asset($event->image_url) }}" alt="Event Image" class="event-card-image">
                                @endif
                                <div class="card-body">
                                    <h3 class="event-card-title">{{ $event->title }}</h3>
                                    <p class="event-card-description">{{ $event->description }}</p>
                                    <p class="card-text"><small class="text-muted" style="font-size: 18px;"><span>📌</span>:&nbsp&nbsp{{ $event->location }}</small></p>
                                    <p class="card-text"><small class="text-muted" style="font-size: 15px;"><span>📆</span>:&nbsp&nbsp{{ $event->start_date }} to</small></p>
                                    <p class="card-text"><small class="text-muted" style="padding-left: 33px; font-size: 15px;">{{ $event->end_date }}</small></p>
                                </div>
                                <div class="card-footer event-card-footer">
                                    <!-- View Details Button -->
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#eventModalContainer{{ $event->id }}">
                                        View Details
                                    </button>

                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editEventModal{{ $event->id }}">
                                        Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                           Delete
                                        </button>
                                    </form>

                                    @if (!$event->users->contains(auth()->user()))
                                        <!-- Subscribe Form -->
                                        <form action="{{ route('events.subscribe', $event) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success" style="margin-top: 10px;">Subscribe</button>
                                        </form>
                                    @else
                                        <!-- Unsubscribe Form -->
                                        <form action="{{ route('events.unsubscribe', $event) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="margin-top: 10px;">Unsubscribe</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Event Detail and Comments Modals Container -->
                        <div class="modal fade" id="eventModalContainer{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="eventModalLabelContainer{{ $event->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <!-- Event Detail Modal -->
                                <div class="modal-content">
                                    <div class="modal-body">
                                        @if ($event->image_url)
                                            <img src="{{ asset($event->image_url) }}" alt="Event Image" class="img-fluid mb-3">
                                        @endif
                                        <h3 class="modal-title" id="eventModalLabel{{ $event->id }}">{{ $event->title }}</h3>
                                        <p>{{ $event->description }}</p>
                                        <p class="card-text"><small class="text-muted" style="font-size: 18px;"><span>📌</span>:&nbsp&nbsp{{ $event->location }}</small></p>
                                        <p class="card-text"><small class="text-muted" style="font-size: 15px;"><span>📆</span>:&nbsp&nbsp{{ $event->start_date }} to</small></p>
                                        <p class="card-text"><small class="text-muted" style="padding-left: 33px; font-size: 15px;">{{ $event->end_date }}</small></p>
                                    </div>
                                    <div class="modal-footer">
                                        @if (!$event->users->contains(auth()->user()))
                                            <form action="{{ route('events.subscribe', $event) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Subscribe</button>
                                            </form>
                                        @else
                                            <form action="{{ route('events.unsubscribe', $event) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Unsubscribe</button>
                                            </form>
                                            <div class="mt-2">
                                                <span class="text-success">Subscribed!</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- End Event Detail Modal -->

                                <!-- Comments Modal -->
                                <div class="modal-content comments">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="margin-left: 20px;">Comments</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">X</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @if($event->comments->isNotEmpty())
                                            <ul class="list-group mb-3">
                                                @foreach ($event->comments as $comment)
                                                    <li class="list-group-item">
                                                        <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                                                        <br>
                                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No comments yet.</p>
                                        @endif

                                        <!-- Comment Form -->
                                        <form action="{{ route('comments.store', $event) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <textarea class="form-control" name="content" rows="3" placeholder="Add a comment..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Comment</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- End Comments Modal -->
                            </div>
                        </div>
                        <!-- End Event Detail and Comments Modals Container -->

                        <!-- Edit Event Modal -->
                        <div class="modal fade" id="editEventModal{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel{{ $event->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content edit">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editEventModalLabel{{ $event->id }}">Edit Event</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group">
                                                <label for="edit_image">Event Image</label>
                                                <input type="file" class="form-control-file" id="edit_image" name="image">
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_title">Title</label>
                                                <input type="text" class="form-control" id="edit_title" name="title" value="{{ $event->title }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_description">Description</label>
                                                <textarea class="form-control" id="edit_description" name="description" required>{{ $event->description }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_location">Location</label>
                                                <input type="text" class="form-control" id="edit_location" name="location" value="{{ $event->location }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_start_date">Start Date</label>
                                                <input type="datetime-local"                                                 class="form-control" id="edit_start_date" name="start_date" value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_end_date">End Date</label>
                                                <input type="datetime-local" class="form-control" id="edit_end_date" name="end_date" value="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Event Modal -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Event Creation Modal -->
    <div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content create">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEventModalLabel" style="margin-left: 20px;">Create Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">Event Image</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Event Creation Modal -->
</x-app-layout>

