<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id','event_id','quantity','total_amount',
        'payment_method','status','code','qr_path'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
