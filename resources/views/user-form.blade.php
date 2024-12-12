<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($user) ? __('Edit User') : __('New User') }}
        </h2>
    </x-slot>

    

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Image Preview -->
                    <div class="mt-2">
                        <img 
                            id="profilePreview" 
                            src="{{ isset($user) && $user->profile ? asset('storage/Uploads/users-profile/'.$user->profile) : '' }}" 
                            alt="Profile preview" 
                            style="max-width: 64px; {{ isset($user) && $user->profile ? '' : 'display: none;' }}" 
                        />
                    </div>
                    <!-- User Form -->
                    <form 
                        method="POST" 
                        action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}" 
                        enctype="multipart/form-data" 
                        class="p-4"
                    >
                        @csrf
                        @if (isset($user))
                            @method('PUT')
                        @endif

                        <div class="max-w-lg mx-auto">
                            <!-- Profile -->
                            <div class="mb-4">
                                <x-input-label for="profile" :value="__('Profile')" />
                                <input 
                                    id="profile" 
                                    type="file" 
                                    name="profile" 
                                    class="block mt-1 w-full"
                                />
                                <x-input-error :messages="$errors->get('profile')" class="mt-2" />
                            </div>

                            <!-- Name -->
                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Name')" />
                                <input 
                                    id="name" 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name', $user->name ?? '') }}" 
                                    class="block mt-1 w-full"
                                />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email ?? '') }}" 
                                    class="block mt-1 w-full"
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <input 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    class="block mt-1 w-full"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <input 
                                    id="password_confirmation" 
                                    type="password" 
                                    name="password_confirmation" 
                                    class="block mt-1 w-full"
                                />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button 
                                type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                {{ isset($user) ? __('Update') : __('Add') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profile').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('profilePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
</x-app-layout>

