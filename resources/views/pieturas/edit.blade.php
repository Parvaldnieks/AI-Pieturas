<x-app-layout class="max-w-md mx-auto p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Rediģēt Pieturu') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <form method="POST" action="{{ route('pieturas.update', $pietura->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex items-center space-x-3">
                <div class="w-1/2">
                    <label class="block text-gray-700 dark:text-gray-300">{{ __('Nosaukums') }}</label>
                    <input type="text" id="name" name="name" class="block mt-1 w-full rounded-md border-gray-200 dark:border-gray-600 dark:bg-gray-800 focus:border-purple-500 dark:focus:border-purple-500 focus:outline-none focus:ring-0 sm:text-sm" value="{{ old('name', $pietura->name) }}">
                </div>

                <div class="w-1/2">
                    <label class="block text-gray-700 dark:text-gray-300">{{ __('Teksts') }}</label>
                    <input type="text" id="text" name="text" class="block mt-1 w-full rounded-md border-gray-200 dark:border-gray-600 dark:bg-gray-800 focus:border-purple-500 dark:focus:border-purple-500 focus:outline-none focus:ring-0 sm:text-sm" value="{{ old('name', $pietura->text) }}">
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-gray-100 rounded-md group-hover:bg-transparent">
                        {{ __('Saglabāt') }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
