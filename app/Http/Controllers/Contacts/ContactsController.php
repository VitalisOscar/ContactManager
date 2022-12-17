<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contacts\ContactDataRequest;
use App\Models\PhoneNumber;
use App\Traits\ContactManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ContactsController extends Controller
{

    use ContactManager;

    /**
     * Show a new contact form
     */
    function showForm(){
        return response()->view('contacts.add', [
            'labels' => PhoneNumber::LABELS
        ]);
    }

    /**
     * Show list of user's contacts
     */
    function getAll(Request $request){
        $result = $request->user() // For the current user
            ->contacts()
            ->aToZ() // Order by name
            ->paginate(50); // Limit per page

        return response()->view('contacts.all', [
            'contacts' => $result,
            'labels' => PhoneNumber::LABELS
        ]);
    }

    /**
     * Show a single user's contact
     */
    function getSingle($contact){
        return response()->view('contacts.single', [
            'contact' => $contact,
            'labels' => PhoneNumber::LABELS
        ]);
    }


    /**
     * Handle request to add a new contact
     */
    function create(ContactDataRequest $request){
        try{

            $data = $request->validated();

            // Just ensure we have at least 1 phone number
            if(count($data['phone_numbers'] ?? []) < 1){
                return back()
                    ->withInput()
                    ->withErrors([
                        'status' => 'Add at least one phone number'
                    ]);
            }

            // We expect to run several db operations
            DB::beginTransaction();

            // Create the contact
            $contact = $this->newContact(
                $request->user(),
                $data
            );

            if(is_string($contact)){
                // An error occurred, stop and return the
                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'status' => $contact
                    ]);
            }

            // Done
            DB::commit();

            return back()
                ->with([
                    'status' => 'Contact created successfully'
                ]);

        }catch(\Exception $e){
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'status' => Lang::get('app.server_error')
                ]);
        }
    }

    /**
     * Handle request to edit an existing contact
     */
    function edit(ContactDataRequest $request, $contact){
        try{

            $data = $request->validated();

            // Just ensure we have at least 1 phone number
            if(count($data['phone_numbers'] ?? []) < 1){
                return back()
                    ->withInput()
                    ->withErrors([
                        'status' => 'Add at least one phone number'
                    ]);
            }

            // We expect to run several db operations
            DB::beginTransaction();

            // Update the contact
            $result = $this->editContact(
                $contact,
                $data
            );

            if(is_string($result)){
                // An error occurred, stop and return the
                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'status' => $result
                    ]);
            }

            // Done
            DB::commit();

            return back()
                ->with([
                    'status' => 'Contact updated successfully'
                ]);

        }catch(\Exception $e){
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'status' => Lang::get('app.server_error')
                ]);
        }
    }

    /**
     * Handle request to delete an existing contact
     */
    function delete($contact){
        try{
            // We expect multiple delete sql statements to be executed
            DB::beginTransaction();

            // Delete
            $contact->delete();

            // Done
            DB::commit();

            return back()
                ->with([
                    'status' => 'Contact deleted successfully'
                ]);

        }catch(Exception $e){
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'status' => 'Something went wrong on our end. You can try again or leave us a message if that persists'
                ]);
        }
    }


}
