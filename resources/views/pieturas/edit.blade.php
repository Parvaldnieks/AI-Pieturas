<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rediģēt Pieturu') }}
        </h2>
    </x-slot>

    <div class="mt-4">
        <form method="POST" action="{{ route('pieturas.update', $pietura->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mt-4">
                <label class="block text-gray-700 dark:text-gray-300">{{ __('Nosaukums') }}</label>
                <input type="text" id="name" name="name" class="block mt-1 w-full rounded-md border-gray-200 dark:border-gray-600 dark:bg-gray-800 focus:border-purple-500 dark:focus:border-purple-500 focus:outline-none focus:ring-0 sm:text-sm" value="{{ old('name', $pietura->name) }}">
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 dark:text-gray-300">{{ __('Teksts') }}</label>
                <input type="text" id="text" name="text" class="block mt-1 w-full rounded-md border-gray-200 dark:border-gray-600 dark:bg-gray-800 focus:border-purple-500 dark:focus:border-purple-500 focus:outline-none focus:ring-0 sm:text-sm" value="{{ old('name', $pietura->text) }}">
            </div>

            <div class="mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
