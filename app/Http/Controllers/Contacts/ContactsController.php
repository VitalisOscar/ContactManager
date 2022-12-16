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
            'contact' => $contact
        ]);
    }


    /**
     * Handle request to add a new contact
     */
    function create(ContactDataRequest $request){
        try{

            // We expect to run several db operations
            DB::beginTransaction();

            // Create the contact
            $contact = $this->newContact(
                $request->user(),
                $request->validated()
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

    }

    /**
     * Handle request to delete an existing contact
     */
    function delete(Request $request, $contact){
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
