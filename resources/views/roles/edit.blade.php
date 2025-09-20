@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">{{ __('Edit Role') }}</h2>
                    </div>

                    <!-- Role Name -->
                    <div class="mb-6">
                        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Nama Role') }}</label>
                        <input type="text" name="name" id="name" value="{{ $role->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        @error('name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('roles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                            {{ __('Batal') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Simpan Perubahan') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Permissions Management Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">{{ __('Kelola Permission untuk Role: ') }} <span class="text-blue-600">{{ $role->name }}</span></h2>
                </div>

                <form method="POST" action="{{ route('roles.updatePermissions', $role->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Permissions -->
                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-2">{{ __('Pilih Permission yang Diizinkan') }}</label>
                        
                        <div class="bg-gray-50 p-4 rounded-lg max-h-96 overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($permissions as $permission)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permissions[]" id="permission_{{ $permission->id }}" 
                                            value="{{ $permission->id }}" 
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-gray-600">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('permissions')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Simpan Permission') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection