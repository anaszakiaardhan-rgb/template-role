@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">{{ __('Permissions Management') }}</h2>
                    <a href="{{ route('permissions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Create New Permission') }}
                    </a>
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
                                    {{ __('Used By Roles') }}
                                </th>
                                <th class="py-3 px-4 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $permission->id }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $permission->name }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">{{ $permission->guard_name }}</td>
                                    <td class="py-3 px-4 border-b border-gray-200">
                                        <span class="text-xs">{{ $permission->roles->count() }} roles</span>
                                        <div class="flex flex-wrap mt-1">
                                            @foreach ($permission->roles->take(3) as $role)
                                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-1 mb-1 px-2 py-0.5 rounded">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                            @if ($permission->roles->count() > 3)
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-1 mb-1 px-2 py-0.5 rounded">
                                                    +{{ $permission->roles->count() - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 border-b border-gray-200">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('permissions.edit', $permission->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form method="POST" action="{{ route('permissions.destroy', $permission->id) }}" onsubmit="return confirm('Are you sure you want to delete this permission?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-4 border-b border-gray-200 text-center">
                                        {{ __('No permissions found.') }}
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