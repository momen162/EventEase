<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title','description','location','starts_at','ends_at',
        'capacity','created_by','price','banner_path','allow_pay_later'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'allow_pay_later' => 'boolean',
    ];

    public function creator(){ return $this->belongsTo(User::class, 'created_by'); }
    public function tickets(){ return $this->hasMany(Ticket::class); }
}
