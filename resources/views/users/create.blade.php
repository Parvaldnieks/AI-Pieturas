<x-app-layout>
    <div class="container max-w-[500px] mx-auto p-4">
        <x-slot name="header">
            <h2 class="font-semibold text-xl dark:text-white">
                {{ t('users.create.view', 'Izveidot Lietotāju') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm">
            <form 
                action="{{ route('users.store') }}" 
                method="POST" 
                class="bg-white dark:bg-black shadow rounded-lg p-6 space-y-4"
            >
                @csrf

                <div>
                    <x-input-label for="name" :value="t('users.create.name', 'Vārds')" />
                    <x-text-input 
                        id="name"
                        name="name"
                        type="text"
                        class="mt-1 block w-full"
                        :value="old('name')"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="t('users.create.email', 'E-pasts')" />
                    <x-text-input 
                        id="email"
                        name="email"
                        type="email"
                        class="mt-1 block w-full"
                        :value="old('email')"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="t('users.create.password', 'Parole')" />
                    <x-text-input 
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-between mt-6">
                    <x-primary-button href="{{ route('users.index') }}">
                        {{ t('users.create.back', 'Atpakaļ') }}
                    </x-primary-button>

                    <x-primary-button>
                        {{ t('users.create.save', 'Saglabāt') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
