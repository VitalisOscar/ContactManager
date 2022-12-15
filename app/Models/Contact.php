<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // We'll use this image for contacts with no provided contact photos
    const DEFAULT_CONTACT_PHOTO = 'contacts/default.png';

    protected $fillable = [
        'full_name',
        'email',
        'photo',
        'phone_numbers',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'phone_numbers' => 'array', // Will be stored as a json list
    ];



    // RELATIONS
    function user(){
        return $this->belongsTo(User::class);
    }



    // ACCESSORS

    /**
     * Modify the contact photo to be a full public URL pointing to the image
     * @return string
     */
    function getPhotoAttribute($path){
        return asset('storage/'.($path ?? self::DEFAULT_CONTACT_PHOTO));
    }
}
