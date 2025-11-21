<x-app-layout>
    <div class="max-w-md mx-auto">
    <x-slot name="header">
        <h2 class="font-bold text-xl dark:text-white">
            {{ t('users.show.view', 'Lietotāja Informācija') }}
        </h2>
    </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">
            <div class="bg-white dark:bg-black shadow rounded-lg p-4">
                <div class="dark:text-white">
                    <p><strong>{{ t('users.show.id', 'ID:') }}</strong> {{ $user->id }}</p>
                    <p><strong>{{ t('users.show.name', 'Vārds:') }}</strong> {{ $user->name }}</p>
                    <p><strong>{{ t('users.show.email', 'E-pasts:') }}</strong> {{ $user->email }}</p>
                    <p><strong>{{ t('users.show.admin', 'Administrators:') }}</strong> {{ $user->admin ? t('users.show.yes', 'Jā') : t('users.show.no', 'Nē') }}</p>
                    <p><strong>{{ t('users.show.created', 'Kad izveidots:') }}</strong> {{ $user->created_at }}</p>
                    <p><strong>{{ t('users.show.update', 'Kad atjaunots:') }}</strong> {{ $user->updated_at }}</p>
                </div>

                <div class="flex justify-between mt-4">
                    <x-primary-button href="{{ route('users.index') }}">
                            {{ t('users.show.back', 'Atpakaļ') }}
                    </x-primary-button>

                    <x-primary-button href="{{ route('users.edit', $user) }}">
                            {{ t('users.show.edit', 'Rediģēt') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
