@extends('layouts.app')

@section('title', 'Register')
@section('hide_topbar', '1')
@section('body_class', 'auth-simple')

@section('content')
    <div class="auth-shell">
        <div class="auth-card">
            <div>
                <h2 class="auth-title">Register</h2>
                <p class="helper">Create an account to start managing your tasks.</p>
            </div>

            <form action="{{ route('register.store') }}" method="POST" class="form-grid">
                @csrf

                <div class="field">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid-two">
                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required>
                        @error('password')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required>
                    </div>
                </div>

                <button class="button" type="submit">Create Account</button>
            </form>

            <p class="helper">Already have an account? <a href="{{ route('login') }}" style="color: var(--accent); font-weight:700;">Login</a></p>
        </div>
    </div>
@endsection
