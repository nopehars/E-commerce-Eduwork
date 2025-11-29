@extends('layouts.adminNavbar')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="p-6 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('admin.profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow sm:rounded-lg mt-6">
            <div class="max-w-xl">
                @include('admin.profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 bg-white shadow sm:rounded-lg mt-6">
            <div class="max-w-xl">
                @include('admin.profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
