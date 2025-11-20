<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-white">
            {{ t('vestures.index.view', 'Vēsture') }}
        </h2>
    </x-slot>

    <x-tables.vestures-table :vestures="$vestures" />
</x-app-layout>
