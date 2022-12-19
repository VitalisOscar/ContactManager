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
     * Handles all the process for updating an existing contact
     *
     * @param Contact $contact
     * @param array $data
     *
     * @return string|Contact
     */
    function editContact($contact, $data){
        try{
            // Update contact data if it has been passed
            if(isset($data['full_name'])){
                $contact->full_name = $data['full_name'];
            }

            if(isset($data['email'])){
                $contact->email = $data['email'];
            }

            if(isset($data['photo'])){
                $contact->photo = $data['photo']->store(Contact::PHOTO_UPLOAD_DIR, 'public');
            }

            // Save only if changes have been made
            if($contact->isDirty()){
                if(!$contact->save()){
                    return Lang::get('app.unknown_error');
                }
            }


            // Update phone numbers
            foreach($contact->phone_numbers as $phone_number){

                // Go through submitted phone number data to get data
                // for the particular phone number
                foreach($data['phone_numbers'] as $key => $phone_data){
                    if(
                        isset($phone_data['id']) &&
                        (
                            $phone_data['id'] == $phone_number->id ||
                            $phone_data['number'] == $phone_number->number
                        ) // Same number or id
                    ){

                        // Update the phone if changes have been made
                        $result = $this->editPhone(
                            $phone_number,
                            $phone_data['number'],
                            $phone_data['label'] ?? null
                        );

                        if(is_string($result)){
                            // An error occurred, return the error
                            return $result;
                        }

                        // Remove the data - we have already dealt with it
                        unset($data['phone_numbers'][$key]);

                        // Phone number has been updated, break out of the loop
                        break;
                    }
                }


            } // Done updating phone numbers

            // Go through submitted data again, to make add any newly added phone numbers
            foreach($data['phone_numbers'] as $phone_data){
                // Check if phone number exists
                if($contact->hasPhoneNumber($phone_data['number'])){
                    continue;
                }

                // Add the phone number
                $result = $this->addPhoneToContact(
                    $contact,
                    $phone_data['number'],
                    $phone_data['label'] ?? null
                );

                if(is_string($result)){
                    // An error occurred, return the error
                    return $result;
                }

                // Phone number has been updated, break out of the loop
                break;
            } // Done adding any new phone numbers


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
            return Lang::get('app.server_error');
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

            // Add Changes
            $phone->number = $number;
            $phone->label = $label ?? 'Other';

            // Update only if dirty
            if($phone->isDirty()){
                if($phone->save()){
                    return true;
                }else{
                    return Lang::get('app.unknown_error');
                }
            }

            return true;

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
