<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'location',
        'starts_at', 'ends_at', 'capacity', 'price'
    ];

    protected $dates = ['starts_at', 'ends_at'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
