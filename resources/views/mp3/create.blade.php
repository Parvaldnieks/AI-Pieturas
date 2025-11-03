<x-app-layout>
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold">{{ __('Create') }}</h1>

    <form method="POST" action="{{ route('mp3.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mt-4">
            <label class="block text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
            <input type="text" id="name" name="name" class="block mt-1 w-full rounded-md border-gray-200 dark:border-gray-600 dark:bg-gray-800 focus:border-purple-500 dark:focus:border-purple-500 focus:outline-none focus:ring-0 sm:text-sm" value="{{ old('name') }}">
        </div>

        <div class="mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</div>
</x-app-layout>
