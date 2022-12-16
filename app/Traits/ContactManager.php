<?php

namespace App\Traits;

use App\Models\Contact;
use App\Models\PhoneNumber;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Lang;

trait ContactManager{

    /**
     * Handles all the process for creating a new contact
     *
     * @param User $user
     * @param array $data
     *
     * @return string|Contact
     */
    function newContact($user, $data){
        try{

            // Create a new contact
            $contact = $user->contacts()->create([
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'photo' => isset($data['photo']) ?
                    $data['photo']->store(Contact::PHOTO_UPLOAD_DIR, 'public')
                    :
                    null,
            ]);


            // Add phone numbers
            foreach($data['phone_numbers'] as $phone){
                $result = $this->addPhoneToContact($contact, $phone['number'], $phone['label']);

                if(is_string($result)){
                    // An error occurred, stop and return the error
                    return $result;
                }
            }


            // Return the new contact
            return $contact;

        }catch(Exception $e){
            return Lang::get('app.server_error');
        }
    }

    /**
     * Handles all the process for creating a new contact
     *
     * @param Contact $contact
     * @param array $data
     *
     * @return string|Contact
     */
    function editContact($contact, $data){
        try{

            if($data['full_name']){
                $contact->full_name = $data['full_name'];
            }

            if($data['email']){
                $contact->email = $data['email'];
            }

            if($data['photo']){
                $contact->photo = $data['photo']->store(Contact::PHOTO_UPLOAD_DIR, 'public');
            }

            // Save only if changes have been made
            if($contact->isDirty()){
                $contact->save();
            }

            // Manage phone numbers
            foreach($contact->phone_numbers as $phone_number){
                // Check if the phone number has an update
                $update = array_filter($data['phone_numbers'], function($phone) use ($phone_number){
                    return $phone['id'] == $phone_number->id;
                });

                if($update){
                    // Update the phone number
                    $phone_number->number = $update['number'];
                    $phone_number->label = $update['label'];

                    // Save only if changes have been made
                    if($phone_number->isDirty()){
                        $phone_number->save();
                    }
                }
            }

            // Return the updated contact
            return $contact;

        }catch(Exception $e){
            return Lang::get('app.server_error');
        }
    }

    /**
     * Add a phone number to a contact
     *
     * @param Contact $contact
     * @param string $number The phone number
     * @param string $label The number's label e.g Work, Mobile, etc.
     *
     * @return PhoneNumber|string
     */
    function addPhoneToContact($contact, $number, $label){
        try{

            // Create a new phone number
            $phone_number = $contact->phone_numbers()->create([
                'number' => $number,
                'label' => $label ?? 'Other',
            ]);

            return $phone_number;

        }catch(Exception $e){
            return Lang::get('app.server_error').$e->getMessage();
        }
    }

    /**
     * Add a phone number to a contact
     *
     * @param PhoneNumber $phone The phone number model
     * @param string $number The phone number
     * @param string $label The number's label e.g Work, Mobile, etc.
     *
     * @return string|true
     */
    function editPhone($phone, $number, $label){
        try{

            // Create a new phone number
            if(
                $phone->update([
                    'number' => $number,
                    'label' => $label ?? 'Other',
                ])
            ){
                return true;
            }

            return Lang::get('app.unknown_error');

        }catch(Exception $e){
            return Lang::get('app.server_error');
        }
    }

    /**
     * Remove a single phone number from a contact
     *
     * @param PhoneNumber $phone The phone number to remove
     *
     * @return string|true
     */
    function removePhone($phone){
        try{
            if($phone->delete()){
                return true;
            }

            return Lang::get('app.unknown_error');

        }catch(Exception $e){
            return Lang::get('app.server_error');
        }
    }

}
