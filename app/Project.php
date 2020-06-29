<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'description', 'notes'];

    public function path()
    {
        return "/projects/{$this->id}";
    }

//    public function addTasks($tasks)
//    {
//        return $this->tasks()->createMany($tasks);
//    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    /**
     * Record activity of Project
     * @param String $description
     */

    public function recordActivity($description)
    {
//        Activity::create([
//            'project_id' => $this->id,
//            'description' => $description,
//        ]);
        // You can use the activity method which represent the relationship
        $this->activity()->create(compact('description'));
    }

    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function activity()
    {
        return $this->hasMany('App\Activity')->latest();
    }

}
