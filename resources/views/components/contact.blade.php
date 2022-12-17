<div href="{{ route('app.contacts.single', $contact) }}" class="row contact">
    {{-- Link - we will trigger clicks programmatically when sections of the contact are clicked --}}
    <a href="{{ route('app.contacts.single', $contact) }}" id="contact-link-{{ $contact->id }}" class="d-none"></a>
    
    <div class="col-6 col-sm-3 contact-item">
        <div class="d-flex align-items-center" onclick="document.querySelector('#contact-link-{{ $contact->id }}').click()">
            <img src="{{ $contact->photo }}" alt="Photo" class="contact-photo" />
            <div class="ml-4">{{ $contact->full_name }}</div>
        </div>
    </div>

    <div class="col-4 contact-item d-none d-sm-block">
        <span onclick="document.querySelector('#contact-link-{{ $contact->id }}').click()">{{ $contact->email }}</span>
    </div>

    <div class="col-3 contact-item" onclick="document.querySelector('#contact-link-{{ $contact->id }}').click()">
        <div>{{ $contact->phone }}</div>

        {{-- If contact has more phone numbers --}}
        @if($contact->phone_numbers_count > 1)
        <span class="ml-3 small">{{ '(+'.($contact->phone_numbers_count - 1).' more)' }}</span>
        @endif
    </div>

    <div class="col-3 col-sm-2 contact-item contact-actions">
        <div class="d-flex align-items-center">
            <a class="edit action" href="{{ route('app.contacts.single', $contact) }}">
                <i class="fa fa-pen"></i>
            </a>

            {{-- hidden delete form --}}
            <form style="display: none" id="delete_{{ $contact->id }}" method="post" action="{{ route('app.contacts.delete', $contact)}}">
                @method('DELETE')
                @csrf
            </form>
            
            {{-- When clicked, submit the form --}}
            <a class="delete action ml-3" onclick="
                if(confirm('Delete the contact {{ $contact->full_name }}? This action is irreversible')){
                    document.querySelector('#delete_{{ $contact->id }}').submit()
                }
            "
            >
                <i class="fa fa-trash"></i>
            </a>
        </div>
    </div>

</div>