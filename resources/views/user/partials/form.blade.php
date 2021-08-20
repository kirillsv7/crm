<form action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" method="POST">
    @if(isset($user)) @method('PUT') @endif
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
        <label>Name</label>
        <input class="form-control" name="name" type="text" value="{{ old('name') ?? $user->name ?? '' }}" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input class="form-control" name="email" type="email" value="{{ old('email') ?? $user->email ?? '' }}" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input class="form-control" name="password" type="password" minlength="8">
    </div>
    <div class="form-group">
        <label>Password confirmation</label>
        <input class="form-control" name="password_confirmation" type="password" minlength="8">
    </div>
    <div class="custom-control custom-switch mb-3">
        <input name="is_admin" type="hidden" value="0">
        <input id="is_admin" class="custom-control-input" name="is_admin" type="checkbox" value="1"
               @if(isset($user) && $user->is_admin) checked @endif>
        <label class="custom-control-label" for="is_admin">Is admin</label>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
</form>
