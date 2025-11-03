<x-app-layout>
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('MP3') }}
        </h2>
    </x-slot>

    <div class="flex justify-center">
        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            href="{{ route('mp3.create') }}">
            {{ __('Create') }}
        </a>
    </div>

    <div class="ml-12">
        @foreach($mp3 as $data)
            <li class="flex items-center">
                <a href="{{ route('mp3.edit', $data->id) }}" class="text-blue-500 hover:text-blue-700 hover:underline">
                    {{ $data->name }}
                </a>
                <form method="POST" action="{{ route('mp3.destroy', $data->id) }}" class="ml-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 hover:underline">
                        {{ __('Delete') }}
                    </button>
                </form>
            </li>
         @endforeach
    </div>
</x-app-layout>
