<div class="table-responsive">
    <table class="table table-borderless table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Is admin</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Deleted</th>
            <th>Actions</th>
        </tr>
        </thead>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->is_admin)
                        <i class="cil-check-alt text-success"></i>
                    @else
                        <i class="cil-x text-muted"></i>
                    @endif
                </td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
                <td>{{ $user->deleted_at }}</td>
                <td>
                    @if(!$user->trashed())
                        <a class="btn btn-secondary btn-sm"
                           href="{{ route('user.edit', $user->id) }}">
                            <i class="cil-pencil"></i>
                        </a>
                        <form class="d-inline-block" action="{{ route('user.destroy', $user->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-light btn-sm" type="submit"
                                    onclick="return confirm('Are you sure you want to delete?');">
                                <i class="cil-trash"></i>
                            </button>
                        </form>
                    @else
                        <form class="d-inline-block" action="{{ route('user.restore', $user->id) }}"
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
