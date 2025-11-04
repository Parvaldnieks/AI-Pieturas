<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('Vēsture') }}
        </h2>
    </x-slot>

    <x-vestures-list :vestures="$vestures" />
</x-app-layout>
