@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Roles and Permissions</h1>

    <form action="{{ route('users.assignRolePermission') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user">Select User</label>
            <select name="user_id" id="user" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="roles">Assign Roles</label>
            <select name="roles[]" id="roles" class="form-control" multiple>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="permissions">Assign Permissions</label>
            <select name="permissions[]" id="permissions" class="form-control" multiple>
                @foreach ($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Assign</button>
    </form>
</div>
@endsection