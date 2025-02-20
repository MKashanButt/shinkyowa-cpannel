<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full p-2 bg-gray-200" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full p-2 bg-gray-200" type="email" name="email"
                :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full p-2 bg-gray-200" type="password" name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full p-2 bg-gray-200" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('User Role')" />
            <select
                class="block mt-1 w-full p-2 bg-gray-200 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                id="role" name="role">
                <option value="" selected>Select Role</option>
                @foreach ($roles as $item)
                    <option value="{{ $item }}">{{ strtoupper(str_replace('_', ' ', $item)) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4 hidden" id="managers">
            <x-input-label for="manager" :value="__('Manager')" />

            <select
                class="block mt-1 w-full p-2 bg-gray-200 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                id="manager" name="manager">
                <option value="" selected>Select Manager</option>
                @foreach ($managers as $item)
                    <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <script>
        document.getElementById('role').addEventListener('change', function() {
            const role = document.getElementById('role').value
            const managerField = document.getElementById('managers')
            if (role == 'agent') {
                managerField.classList.remove('hidden');
            } else {
                managerField.classList.add('hidden');
            }
        })
    </script>
</x-guest-layout>
