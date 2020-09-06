<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_creating_a_project_records_activity()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    public function test_updating_a_project_records_activity()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $project->update(['title' => 'changed']);
        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    public function test_creating_a_task_update_records_activity()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $project->addTask('Some Task');
        $this->assertCount(2, $project->activity);
        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf('App\Task', $activity->subject);
        });
//        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    public function test_completing_a_task_update_records_activity()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $project->addTask('Add Task');
        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);
        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf('App\Task', $activity->subject);
        });
    }

    public function test_incompleting_a_task_update_records_activity()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        //created
        $project->addTask('Add Task');
        //created task
        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $project->refresh();
        $this->assertCount(3, $project->fresh()->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false,
        ]);

        $this->assertCount(4, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    public function test_deleting_a_task()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $project->addTask('Add Task');

        $project->tasks[0]->delete();
        $this->assertCount(3, $project->fresh()->activity);
        $this->assertEquals('deleted_task', $project->fresh()->activity->last()->description);
    }
}
