<form action="{{ isset($client) ? route('client.update', $client->id) : route('client.store') }}" method="POST">
    @if(isset($client)) @method('PUT') @endif
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label>Company</label>
        <input class="form-control" name="company" type="text" value="{{ old('company') ?? $client->company ?? '' }}"
               required>
    </div>
    <div class="form-group">
        <label>VAT</label>
        <input class="form-control" name="vat" type="text" value="{{ old('vat') ?? $client->vat ?? '' }}" required>
    </div>
    <div class="form-group">
        <label>Address</label>
        <input class="form-control" name="address" type="text" value="{{ old('address') ?? $client->address ?? '' }}"
               required>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
</form>
