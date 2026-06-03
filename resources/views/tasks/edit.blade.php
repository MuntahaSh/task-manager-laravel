@extends('layouts.app')

@section('title', 'Edit Task | My Tasks')

@section('content')
    <div class="page-head">
        <div>
            <h2 class="page-title">Edit task</h2>
        </div>
        <a class="button-ghost" href="{{ route('tasks.index') }}">Back</a>
    </div>

    <div class="card">
        <form action="{{ route('tasks.update', $task) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')
            {{-- I use one form file for create and edit. --}}
            @include('tasks.partials.form', ['task' => $task])

            <div class="inline-actions">
                <button class="button" type="submit">Update task</button>
                <a class="button-ghost" href="{{ route('tasks.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
