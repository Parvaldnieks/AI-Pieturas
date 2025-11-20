<x-app-layout>
    <div class="max-w-[500px] mx-auto p-4">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                {{ t('valodas.edit.view', 'Rediģēt valodu') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 mt-4 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm">
            <div class="bg-white dark:bg-black shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('valodas.update', $valoda) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="name" :value="t('valodas.edit.name', 'Nosaukums')" />

                        <x-text-input 
                            id="name"
                            name="name"
                            type="text"
                            class="mt-1 block w-full"
                            value="{{ old('name', $valoda->name) }}"
                        />

                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="code" :value="t('valodas.edit.code', 'Kods')" />

                        <x-text-input 
                            id="code"
                            name="code"
                            type="text"
                            class="mt-1 block w-full"
                            value="{{ old('code', $valoda->code) }}"
                        />

                        <x-input-error :messages="$errors->get('code')" class="mt-1" />
                    </div>

                    <div class="flex justify-between">
                        <x-primary-button href="{{ route('valodas.index') }}">
                                {{ t('valodas.edit.back', 'Atpakaļ') }}
                        </x-primary-button>

                        <x-primary-button>
                            {{ t('valodas.edit.update', 'Saglabāt') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
