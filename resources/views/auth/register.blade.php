<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-md px-6 py-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Create an Account</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                        Sign in
                    </a>
                </p>
            </div>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('register') }}" class="mt-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit"
                        class="w-full px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>