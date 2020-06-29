<div class="bg-white p-5 rounded-lg shadow mt-3">
    <ul class="text-xs list-reset">
        @foreach($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }} text-gray-700 flex justify-between">
                @include("projects.activity.{$activity->description}")
                <span class="text-gray-500">{{$activity->created_at->diffForhumans(null, true)}}</span>
            </li>
        @endforeach
    </ul>
</div>
