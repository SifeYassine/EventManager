<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Relate events to users through subscriptions table
    public function users()
    {
        return $this->belongsToMany(User::class, 'subscriptions');
    }
}