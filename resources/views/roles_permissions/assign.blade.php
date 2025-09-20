@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">{{ __('Assign Roles and Permissions') }}</h2>
                </div>

                <form action="{{ route('users.assignRolePermission') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="user" class="block font-medium text-sm text-gray-700">{{ __('Select User') }}</label>
                        <select name="user_id" id="user" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-2">{{ __('Assign Roles') }}</label>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($roles as $role)
                                <div class="flex items-center">
                                    <input type="checkbox" name="roles[]" id="role_{{ $role->id }}" 
                                        value="{{ $role->id }}" 
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <label for="role_{{ $role->id }}" class="ml-2 text-sm text-gray-600">{{ $role->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-2">{{ __('Assign Permissions') }}</label>
                        <div class="bg-gray-50 p-4 rounded-lg max-h-96 overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($permissions as $permission)
                                <div class="flex items-center">
                                    <input type="checkbox" name="permissions[]" id="permission_{{ $permission->id }}" 
                                        value="{{ $permission->id }}" 
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-gray-600">{{ $permission->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Assign') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection