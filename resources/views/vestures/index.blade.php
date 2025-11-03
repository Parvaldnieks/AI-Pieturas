<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vēsture') }}
        </h2>
    </x-slot>

    <x-vestures-list :vestures="$vestures" />
</x-app-layout>
