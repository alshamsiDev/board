<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_task_belongs_to_a_project()
    {
        $task = factory('App\Task')->create();
        $this->assertInstanceOf('App\Project', $task->project);
    }
    /** @test */
    public function it_has_a_path()
    {
        $task = factory('App\Task')->create();
        $this->assertEquals("/projects/{$task->project->id}/tasks/{$task->id}", $task->path());
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $this->post($project->path() . '/tasks', ['body' => 'Test Task']);
        $this->get($project->path())
            ->assertSee('Test Task');
    }

    /** @test */
    public function only_the_owner_of_the_project_can_add_tasks()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $this->post($project->path() . '/tasks', ['body' => 'Test Task'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'Test Task']);
    }

    /** @test */
    public function a_tasks_require_body()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $attributes = factory('App\Task')->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $task = $project->addTask('test tasks');
        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed'
        ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $task = $project->addTask('test tasks');
        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_incompleted()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $task = $project->addTask('test tasks');
        $task->complete();
        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }

    /** @test */
    public function only_the_owner_of_the_project_can_update_tasks()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
        $task = $project->addTask('test task');
        $this->patch($task->path(), ['body' => 'Changed'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);
    }
    public function test_it_can_be_completed()
    {
//        $this->signIn();
//        $project = factory('App\Project')->create();
        $task = factory('App\Task')->create();
        $this->assertFalse($task->completed);
        $task->complete();
        $this->assertTrue($task->fresh()->completed);
    }

    public function test_it_can_be_incompleted()
    {
//        $this->signIn();
//        $project = factory('App\Project')->create();
        $task = factory('App\Task')->create(['completed' => true]);
        $this->assertTrue($task->completed);
        $task->incomplete();
        $this->assertFalse($task->fresh()->completed);
    }

}
