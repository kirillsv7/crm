<div class="table-responsive">
    <table class="table table-borderless table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Company</th>
            <th>VAT</th>
            <th>Address</th>
            <th>Created</th>
            <th>Updated</th>
            @if(request()->routeIs('client.deleted'))
                <th>Deleted</th>
            @endif
            <th>Actions</th>
        </tr>
        </thead>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->company }}</td>
                <td>{{ $client->vat }}</td>
                <td>{{ $client->address }}</td>
                <td>{{ $client->created_at }}</td>
                <td>{{ $client->updated_at }}</td>
                @if(request()->routeIs('client.deleted'))
                    <td>{{ $client->deleted_at }}</td>
                @endif
                <td>
                    @if(!$client->trashed())
                        <a class="btn btn-secondary btn-sm"
                           href="{{ route('client.edit', $client->id) }}">
                            <i class="cil-pencil"></i>
                        </a>
                        <form class="d-inline-block" action="{{ route('client.destroy', $client->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-light btn-sm" type="submit"
                                    onclick="return confirm('Are you sure you want to delete?');">
                                <i class="cil-trash"></i>
                            </button>
                        </form>
                    @else
                        <form class="d-inline-block" action="{{ route('client.restore', $client->id) }}"
                              method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit"
                                    onclick="return confirm('Are you sure you want to restore?');">
                                <i class="cil-reload"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>
