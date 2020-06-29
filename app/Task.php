<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    // You can keep them here or create an observer

//    protected static function boot()
//    {
//        parent::boot(); // TODO: Change the autogenerated stub
//        static::created(function ($task) {
//            $task->project->recordActivity('created_task');
//        });
//        static::updated(function ($task) {
//            if (!$task->completed) return;
//            $task->project->recordActivity('completed_task');
//        });
//    }

    protected $fillable = ['body', 'completed'];

    protected $touches = ['project'];

    protected $casts = ['completed' => 'boolean'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function complete()
    {
        $this->update(['completed' => true]);
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
        $this->project->recordActivity('incompleted_task');

    }
}
