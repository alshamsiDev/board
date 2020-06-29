<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Project $project)
    {
        $this->authorize('update', $project); // with Policy

        request()->validate(['body' => 'required']);
        $project->addTask(request('body'));

        return redirect($project->path());
    }


    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project); // with Policy

        $task->update(request()->validate(['body' => 'required'])); // Update body

        request('completed') ? $task->complete() : $task->incomplete();
        /**
         * if (request('completed')) // if we change the checkbox btn
         * {
         * $task->complete();
         * } else {
         * $task->incomplete();
         * }
         */

        //request()->has('completed') we have done this because if the check is false the request doesn't see it

        return redirect($project->path());
    }


    public function destroy($id)
    {
        //
    }
}
