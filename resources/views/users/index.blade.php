<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl dark:text-white">
            {{ t('users.index.view', 'Lietotāji') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-4">
        <x-primary-button href="{{ route('users.create') }}">
                {{ t('users.index.create', 'Izveidot') }}
        </x-primary-button>
    </div>

    <x-tables.users-table :users="$users" />
</x-app-layout>
