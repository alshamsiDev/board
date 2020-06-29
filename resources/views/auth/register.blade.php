@extends('layouts.app')

@section('content')

    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">Sign Up</h1>
        <div class="">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-6">
                    <label for="name"
                           class="block text-gray-700 dark:text-orange-400 text-sm font-bold mb-2">{{ __('Name') }}</label>

                    <div class="">
                        <input id="name" type="text"
                               class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="email"
                           class="block text-gray-700 dark:text-orange-400 text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>

                    <div class="">
                        <input id="email" type="email"
                               class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"

                               name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password"
                           class="block text-gray-700 dark:text-orange-400 text-sm font-bold mb-2">{{ __('Password') }}</label>

                    <div class="">
                        <input id="password" type="password"
                               class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               name="password" required
                               autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password-confirm"
                           class="block text-gray-700 dark:text-orange-400 text-sm font-bold mb-2">{{ __('Confirm Password') }}</label>

                    <div class="">
                        <input id="password-confirm" type="password"
                               class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               name="password_confirmation"
                               required autocomplete="new-password">
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex items-center justify-between">

                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
                                {{ __('Register') }}
                            </button>
                        </div>
                        <div>
                            <a
                                href="{{ route('login')  }}"
                                class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                            >
                                Do you Have an account?
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
