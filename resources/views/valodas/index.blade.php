<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl dark:text-white">
            {{ t('valodas.index.view', 'Valodas') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-4">
        <x-primary-button href="{{ route('valodas.create') }}">
            {{ t('valodas.index.add', 'Pievienot') }}
        </x-primary-button>
    </div>

    <x-tables.valodas-table :valodas="$valodas" :originals="$originals" />
</x-app-layout>
