<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{

    // Allowed Labels
    const LABELS = [
        'Work',
        'Home',
        'Mobile',
        'Office',
        'Other'
    ];

    protected $fillable = [
        'number',
        'label', // Label e.g Work, Mobile, etc.
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];



    // RELATIONS
    function contact(){
        return $this->belongsTo(Contact::class);
    }

}
