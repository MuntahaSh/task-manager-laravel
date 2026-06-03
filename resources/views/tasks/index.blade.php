@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
    <section class="stats">
        <div class="stat">
            <span class="meta">Total tasks</span>
            <strong>{{ $stats['total'] }}</strong>
        </div>
        <div class="stat">
            <span class="meta">Completed</span>
            <strong>{{ $stats['completed'] }}</strong>
        </div>
        <div class="stat">
            <span class="meta">Pending</span>
            <strong>{{ $stats['pending'] }}</strong>
        </div>
        <div class="stat">
            <span class="meta">Overdue</span>
            <strong>{{ $stats['overdue'] }}</strong>
        </div>
    </section>

    <section>
        <div class="page-head" style="margin-bottom:16px;">
            <div>
                <h2 class="page-title" style="font-size:2rem;">My Tasks</h2>
                <p class="helper">Here is your task list.</p>
            </div>
        </div>

        @if ($tasks->isEmpty())
            <div class="empty-state">
                <h3 style="margin-top:0;">No tasks found</h3>
                <p class="helper">Create a new task from the top bar.</p>
            </div>
        @else
            <div class="task-list">
                @foreach ($tasks as $task)
                    @php($isOverdue = $task->status === 'pending' && $task->due_date && $task->due_date->lt(today()))
                    <article class="task-card">
                        <div class="task-header">
                            <div>
                                <div class="meta-row">
                                    <span class="badge {{ $task->status === 'completed' ? 'badge-completed' : 'badge-pending' }}">{{ ucfirst($task->status) }}</span>
                                    @if ($isOverdue)
                                        <span class="badge badge-overdue">Overdue</span>
                                    @endif
                                </div>
                                <h3 class="task-title">{{ $task->title }}</h3>
                            </div>

                            <form action="{{ route('tasks.toggle-status', $task) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="status-button" type="submit">
                                    {{ $task->status === 'completed' ? 'Move to Pending' : 'Mark Completed' }}
                                </button>
                            </form>
                        </div>

                        @if ($task->description)
                            <p class="task-description">{{ $task->description }}</p>
                        @endif

                        <div class="task-footer">
                            <div class="meta-row">
                                <span class="meta">Created {{ $task->created_at->diffForHumans() }}</span>
                                <span class="meta">
                                    Due:
                                    {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No deadline' }}
                                </span>
                            </div>

                            <div class="inline-actions">
                                <a class="button-ghost" href="{{ route('tasks.edit', $task) }}">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button-ghost" type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($tasks->hasPages())
                <div class="pagination">
                    <span>Page {{ $tasks->currentPage() }} of {{ $tasks->lastPage() }}</span>
                    <div class="inline-actions">
                        @if ($tasks->onFirstPage())
                            <span class="button-ghost" style="opacity:.5;">Previous</span>
                        @else
                            <a class="button-ghost" href="{{ $tasks->previousPageUrl() }}">Previous</a>
                        @endif

                        @if ($tasks->hasMorePages())
                            <a class="button" href="{{ $tasks->nextPageUrl() }}">Next</a>
                        @else
                            <span class="button" style="opacity:.5;">Next</span>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    </section>
@endsection
