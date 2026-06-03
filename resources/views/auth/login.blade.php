@extends('layouts.app')

@section('title', 'Login')
@section('hide_topbar', '1')
@section('body_class', 'auth-simple')

@section('content')
    <div class="auth-shell">
        <div class="auth-card">
            <div>
                <h2 class="auth-title">Login</h2>
                <p class="helper">Sign in to manage your tasks.</p>
            </div>

            <form action="{{ route('login.store') }}" method="POST" class="form-grid">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <label class="meta" style="display:flex; gap:10px; align-items:center;">
                    <input type="checkbox" name="remember" value="1" style="width:auto;">
                    Keep me signed in
                </label>

                <button class="button" type="submit">Login</button>
            </form>

            <p class="helper">Do not have an account? <a href="{{ route('register') }}" style="color: var(--accent); font-weight:700;">Register</a></p>
        </div>
    </div>
@endsection
