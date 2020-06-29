@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">{{ __('Login') }}</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6">
                <label for="title"
                       class="block text-gray-700 dark:text-orange-400 text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>

                <div class="">
                    <input id="email" type="email"
                           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <div class="text-red-500 text-sm">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password"
                           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           name="password" required
                           autocomplete="current-password">

                    @error('password')
                    <div class="text-red-500 text-sm">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div class="">
                        <input class="" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    <div class="">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg"
                        >
                            {{ __('Login') }}
                        </button>

                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <a
                        href="{{ route('register')  }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                    >
                        Don't have an account?
                    </a>
                    @if (Route::has('password.request'))
                        <a
                            class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-blue-800"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
