<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
protected $fillable = [
  'title','description','location','venue','starts_at','ends_at','capacity',
  'price','purchase_option','banner','created_by','status','approved_by','approved_at',
];


    protected $casts = [
        'starts_at'   => 'datetime',
        'ends_at'     => 'datetime',
        'approved_at' => 'datetime',
        'price'       => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Optional: always get a usable URL for banner
    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner ? asset(ltrim($this->banner, '/')) : null;
    }
}
