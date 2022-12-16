@dump($errors->all())

<form action="{{ route('app.contacts.update', $contact) }}" method="post" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    <input type="text" name="full_name" value="{{ old('full_name') ?? $contact->full_name }}" placeholder="Name">
    <input type="text" name="email" value="{{ old('email') ?? $contact->email }}" placeholder="Email">

    <br>
    Phone Numbers
    @php $i = 0; @endphp
    @foreach ($contact->phone_numbers as $phone_number)
    <div>
        <input type="hidden" name="phone_numbers[{{ $i }}][id]" value="{{ $phone_number->id }}">
        
        <input type="text" name="phone_numbers[{{ $i }}][number]" value="{{ old('phone_numbers')[$i]['number'] ?? $phone_number->number }}" placeholder="Phone Number">
        
        <select name="phone_numbers[{{ $i }}][label]">
            <option value="">Type</option>
            @foreach($labels as $label)
            <option value="{{ $label }}" @if(old('phone_numbers')[$i]['label'] ?? $phone_number->label == $label){{ __('selected') }}@endif >{{ $label }}</option>
            @endforeach
        </select>
    </div>
    @php $i++; @endphp
    @endforeach

    <img src="{{ $contact->photo }}" alt="{{ $contact->full_name }}" width="50">

    <input type="file" name="photo">

    <input type="submit" value="Update">
</form>

