
    @csrf

    <div class="mb-6">
        <label class="block text-gray-700 dark:text-orange-400 text-sm font-bold mb-2" for="title">
            Title
        </label>
        <input type="text"
               class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
               name="title" id="title"
               id="title"
               placeholder="My next awesome project"
               value="{{ $project->title }}">
    </div>
    <div class="mb-6">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
        <textarea
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="description"
            name="description"
            placeholder="Description"
            rows="3"
        >
                {{ $project->description }}

            </textarea>
    </div>

    <div class="flex items-center justify-between">
        <button
            class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg"
            type="submit">
            {{ $buttonText }}
        </button>
        <a href="{{ $project->path() }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
            Cancel
        </a>
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
