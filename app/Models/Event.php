<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'start_time', 'end_time', 'location', 'user_id', 'team_id'];

    // An event belongs to a user (the creator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Many users can sign up for the event
    public function attendees()
    {
        return $this->belongsToMany(User::class);
    }
}
