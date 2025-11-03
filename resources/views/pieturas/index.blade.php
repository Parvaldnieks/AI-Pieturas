<x-app-layout>
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pieturas') }}
        </h2>
    </x-slot>

    <div class="flex justify-center">
        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            href="{{ route('pieturas.create') }}">
            {{ __('Create') }}
        </a>
    </div>

    <x-pieturas-list :pieturas="$pieturas" />
</x-app-layout>
