<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            {{ t('valodas.index.view', 'Valodas') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-6">
        <x-primary-button href="{{ route('valodas.create') }}">
            {{ t('valodas.index.add', 'Pievienot') }}
        </x-primary-button>
    </div>

    <x-tables.valodas-table :valodas="$valodas" />
</x-app-layout>
