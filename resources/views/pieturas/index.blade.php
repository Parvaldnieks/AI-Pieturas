<x-app-layout>
        <x-slot name="header">
        <h2 class="font-bold text-xl dark:text-white">
            {{ t('pieturas.index.view', 'Pieturas') }}
        </h2>
    </x-slot>

    @if (auth()->user()->hasPermission('izveidot_pieturas'))
        <div class="flex justify-center mt-4">
            <x-primary-button href="{{ route('pieturas.create') }}">
                {{ t('pieturas.create', 'Izveidot') }}
            </x-primary-button>
        </div>
    @endif

    <x-tables.pieturas-table :pieturas="$pieturas" :user="$user_id" :admin="$admin"/>
</x-app-layout>
