<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function index(): View
    {
        // Get only my tasks.
        $userId = auth()->id();
        $tasks = Task::where('user_id', $userId)->latest()->paginate(10);

        // Small numbers for the top cards.
        $today = now()->toDateString();
        $stats = [
            'total' => Task::where('user_id', $userId)->count(),
            'completed' => Task::where('user_id', $userId)->where('status', 'completed')->count(),
            'pending' => Task::where('user_id', $userId)->where('status', 'pending')->count(),
            'overdue' => Task::where('user_id', $userId)
                ->where('status', 'pending')
                ->whereDate('due_date', '<', $today)
                ->count(),
        ];

        return view('tasks.index', compact('tasks', 'stats'));
    }

    public function create(): View
    {
        // Show the add form.
        return view('tasks.create', [
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Save a new task for this user.
        Task::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'due_date' => $data['due_date'] ?? null,
            'completed_at' => $data['status'] === 'completed' ? now() : null,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task): View
    {
        // Stop other users from opening this task.
        $task = Task::where('user_id', auth()->id())->findOrFail($task->id);

        return view('tasks.edit', [
            'task' => $task,
            'statusOptions' => $this->statusOptions(),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        // Update only my task.
        $task = Task::where('user_id', auth()->id())->findOrFail($task->id);
        $data = $request->validated();

        $task->title = $data['title'];
        $task->description = $data['description'] ?? null;
        $task->status = $data['status'];
        $task->due_date = $data['due_date'] ?? null;
        $task->completed_at = $data['status'] === 'completed' ? now() : null;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        // Delete only my task.
        $task = Task::where('user_id', auth()->id())->findOrFail($task->id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function toggleStatus(Task $task): RedirectResponse
    {
        // Switch task status with one click.
        $task = Task::where('user_id', auth()->id())->findOrFail($task->id);
        $task->status = $task->status === 'completed' ? 'pending' : 'completed';
        $task->completed_at = $task->status === 'completed' ? now() : null;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task status updated.');
    }

    private function statusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'completed' => 'Completed',
        ];
    }
}