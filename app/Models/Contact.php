<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // We'll use this image for contacts with no provided contact photos
    const DEFAULT_CONTACT_PHOTO = 'contacts/default.png';

    // The directory where contact photos are stored
    const PHOTO_UPLOAD_DIR = 'contacts';

    protected $fillable = [
        'full_name',
        'email',
        'photo'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $with = ['phone_numbers'];

    protected $append = ['phone_numbers'];


    // RELATIONS
    function user(){
        return $this->belongsTo(User::class);
    }

    function phone_numbers(){
        return $this->hasMany(PhoneNumber::class);
    }


    // SCOPES
    function scopeAToZ($q){
        return $q->orderBy('full_name', 'asc');
    }


    // ACCESSORS

    /**
     * Modify the contact photo to be a full public URL pointing to the image
     * @return string
     */
    function getPhotoAttribute($path){
        return asset('storage/'.($path ?? self::DEFAULT_CONTACT_PHOTO));
    }

    /**
     * We'll use the first phone number of the contact as the default phone number
     * @return string
     */
    function getPhoneAttribute(){
        return $this->phone_numbers()->first()->number;
    }
}
