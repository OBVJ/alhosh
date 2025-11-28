@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

    @if (session('status') === 'profile-updated')
        <div class="mb-4 text-green-600">Profile updated.</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label class="block">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border p-2 w-full" />
            @error('name') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="block">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border p-2 w-full" />
            @error('email') <div class="text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            <a href="/" class="text-sm text-gray-600">Cancel</a>
        </div>
    </form>

    <hr class="my-6">

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-2">
            <label class="block">Password (to delete account)</label>
            <input type="password" name="password" class="border p-2 w-full" />
        </div>

        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Delete Account</button>
    </form>
</div>
@endsection
