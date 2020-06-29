@extends('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-500 text-sm font-normal"><a href="/projects">My Project</a> / {{ $project->title }}</p>
            <a href="{{ $project->path() . '/edit' }}"
               class="text-white bg-blue-400 hover:bg-blue-600 rounded-lg text-sm py-2 px-5">Edit Project</a>
        </div>
    </header>
    <main>
        <div class="lg:flex -m-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-gray-500 font-normal">Tasks</h2>

                    @foreach($project->tasks as $task)
                        <div class="bg-white p-5 rounded-lg shadow mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf

                                <div class="flex">
                                    <input name="body" type="text" value="{{ $task->body }}"
                                           class="w-full {{ $task->completed ? 'text-gray-300' : ''}}">
                                    <input name="completed" type="checkbox"
                                           onChange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="bg-white p-5 rounded-lg shadow mb-3">
                        <form action="{{ $project->path() . '/tasks'}}" method="POST">
                            @csrf
                            <input placeholder="Add a New Task" class="w-full" required name="body">
                        </form>
                    </div>

                </div>


                <div>
                    <h2 class="text-lg text-gray-500 font-normal">General Notes</h2>
                    {{-- General notes --}}
                    <form method="POST" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')

                        <textarea
                            name="notes"
                            class="bg-white p-5 rounded-lg shadow w-full h-40 mb-4"
                            placeholder="Anything special that you want to make note of?"> {{ $project->notes }}
                    </textarea>
                        <button class="bg-blue-400 hover:bg-blue-600 text-white  font-bold py-2 px-4 rounded-full">
                            Save
                        </button>
                    </form>
                </div>

            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')
                @include('projects.activity.card')
            </div>
        </div>
        @if ($errors->any())
            <div class="text-red-500 text-sm mt-6">
                <ul class="">
                    @foreach ($errors->all() as $error)
                        <li class="p-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </main>
@endsection
