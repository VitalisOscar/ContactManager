@foreach ($contacts as $contact)
    <div>
        <a>
            <img src="{{ $contact->photo }}" alt="{{ $contact->full_name }}" width="50">
            {{ $contact->full_name }}<br>
            {{ $contact->phone }}<br>
        </a>
    </div>
@endforeach

@dump($errors->all())

New<br>
<form action="{{ route('app.contacts.create') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Name">
    <input type="text" name="email" value="{{ old('email') }}" placeholder="Email">

    <br>
    Phone Numbers
    <div>
        <input type="text" name="phone_numbers[0][number]" value="{{ old('phone_numbers')[0]['number'] ?? '' }}" placeholder="Phone Number">
        <select name="phone_numbers[0][label]">
            <option value="">Type</option>
            @foreach($labels as $label)
                <option value="{{ $label }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <input type="text" name="phone_numbers[1][number]" value="{{ old('phone_numbers')[1]['number'] ?? '' }}" placeholder="Phone Number">
        <select name="phone_numbers[1][label]">
            <option value="">Type</option>
            @foreach($labels as $label)
                <option value="{{ $label }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <input type="file" name="photo">

    <input type="submit" value="Create">
</form>
