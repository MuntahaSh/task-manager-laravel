@extends('layouts.app')

@section('title', 'Create Task | My Tasks')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Add task</h2>
        </div>
        <a class="button-ghost" href="{{ route('tasks.index') }}">Back</a>
    </div>

    <div class="card">
        <form action="{{ route('tasks.store') }}" method="POST" class="form-grid">
            @csrf
            {{-- I use one form file for create and edit. --}}
            @include('tasks.partials.form')

            <div class="inline-actions">
                <button class="button" type="submit">Save task</button>
                <a class="button-ghost" href="{{ route('tasks.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
