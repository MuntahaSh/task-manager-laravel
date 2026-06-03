<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_only_sees_their_own_tasks(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownTask = Task::factory()->for($user)->create(['title' => 'My private task']);
        Task::factory()->for($otherUser)->create(['title' => 'Other user task']);

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertOk();
        $response->assertSeeText($ownTask->title);
        $response->assertDontSeeText('Other user task');
    }

    public function test_user_can_create_update_toggle_and_delete_a_task(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Launch feature',
            'description' => 'Ship the first task board version',
            'status' => 'pending',
            'due_date' => now()->addDays(3)->toDateString(),
        ])->assertRedirect(route('tasks.index'));

        $task = Task::first();

        $this->assertNotNull($task);
        $this->assertSame($user->id, $task->user_id);

        $this->actingAs($user)->put(route('tasks.update', $task), [
            'title' => 'Launch feature v2',
            'description' => 'Update the details',
            'status' => 'completed',
            'due_date' => now()->addDays(5)->toDateString(),
        ])->assertRedirect(route('tasks.index'));

        $task->refresh();

        $this->assertSame('Launch feature v2', $task->title);
        $this->assertSame('completed', $task->status);
        $this->assertNotNull($task->completed_at);

        $this->actingAs($user)->patch(route('tasks.toggle-status', $task))
            ->assertRedirect(route('tasks.index'));

        $task->refresh();

        $this->assertSame('pending', $task->status);
        $this->assertNull($task->completed_at);

        $this->actingAs($user)->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_manage_another_users_task(): void
    {
        $user = User::factory()->create();
        $otherUserTask = Task::factory()->create();

        $this->actingAs($user)->get(route('tasks.edit', $otherUserTask))
            ->assertNotFound();

        $this->actingAs($user)->put(route('tasks.update', $otherUserTask), [
            'title' => 'Unauthorized change',
            'description' => 'This should not work',
            'status' => 'pending',
            'due_date' => now()->toDateString(),
        ])->assertNotFound();

        $this->actingAs($user)->delete(route('tasks.destroy', $otherUserTask))
            ->assertNotFound();
    }
}
