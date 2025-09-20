@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">{{ __('Roles Management') }}</h2>
                    @can('create-role')
                        <a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Create New Role') }}
                        </a>
                    @endcan
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    {{ __('ID') }}
                                </th>
                                <th class="py-3 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    {{ __('Name') }}
                                </th>
                                <th class="py-3 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    {{ __('Guard') }}
                                </th>
                                <th class="py-3 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    {{ __('Permissions') }}
                                </th>
                                <th class="py-3 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $role->id }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $role->name }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $role->guard_name }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">
                                        <span class="text-xs">{{ $role->permissions->count() }} permissions</span>
                                        <div class="flex flex-wrap mt-1">
                                            @foreach ($role->permissions->take(3) as $permission)
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-1 mb-1 px-2 py-0.5 rounded">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                            @if ($role->permissions->count() > 3)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-1 mb-1 px-2 py-0.5 rounded">
                                                    +{{ $role->permissions->count() - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 border-b border-gray-200">
                                        <div class="flex space-x-2">
                                            @can('edit-role')
                                                <a href="{{ route('roles.edit', $role->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            @endcan
                                            @can('delete-role')
                                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}" onsubmit="return confirm('Are you sure you want to delete this role?');" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-4 border-b border-gray-200 text-center">
                                        {{ __('No roles found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection