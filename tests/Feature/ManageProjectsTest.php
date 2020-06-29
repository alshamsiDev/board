<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithFaker, RefreshDatabase;

    /** @test */
    public function gueset_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/edit')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }

    /** @test */
    public function a_project_requires_a_description()
    {
//        $this->actingAs(factory('App\User')->create());
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description' => '']); //override description to emptied out
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');

    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => $this->faker->paragraph
        ];
        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();
        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $attributes);
        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($project->description)
            ->assertSee($project->notes);

    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function an_auth_user_cannot_view_projects_of_others()
    {
        $this->signIn();
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);

    }

    /** @test */
    public function an_auth_user_cannot_update_projects_of_others()
    {
        $this->signIn();
        $project = factory('App\Project')->create();

        $this->patch($project->path(), [])->assertStatus(403);

    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */
    public function it_can_add_new_tasks()
    {
        $project = factory('App\Project')->create();
        $tasks = $project->addTask('Test Task');
        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($tasks));
    }

    /** @test */
    public function a_user_can_update_project()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $this->patch($project->path(), ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed'])
            ->assertRedirect($project->path());

        $this->get($project->path() .'/edit')->assertOk();
        $this->assertDatabaseHas('projects', [
            'title' => 'Changed',
            'description' => 'Changed',
            'notes' => 'Changed'
        ]);
    }

    public function test_a_user_can_update_project_general_notes()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $this->patch($project->path(), ['notes' => 'Changed'])
            ->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();
        $this->assertDatabaseHas('projects', [
            'notes' => 'Changed'
        ]);
    }
}
