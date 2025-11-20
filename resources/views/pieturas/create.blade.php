<x-app-layout>
    <div class="container mx-auto p-4 flex flex-col items-center" x-data="{ submitting: false }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl dark:text-white">
                {{ t('pieturas.create.view', 'Izveidot Pieturu') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm">
            <form 
                method="POST" 
                action="{{ route('pieturas.store') }}" 
                enctype="multipart/form-data"
                x-on:submit="submitting = true"
                class="bg-white dark:bg-black shadow rounded-lg w-[400px] p-2"
            >
                @csrf

                    <div class="grid grid-cols-1 gap-4 py-4 px-4">
                        <x-input-label for="name" :value="t('pieturas.create.name', 'Nosaukums')" />
                        <x-text-input type="text" id="name" name="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                        <x-input-label for="text" :value="t('pieturas.create.text', 'Teksts')" />
                        <x-text-input type="text" id="text" name="text" />
                        <x-input-error :messages="$errors->get('text')" class="mt-2" />
                    </div>

                    <div class="flex justify-between py-4 px-4">
                        <x-primary-button href="{{ route('pieturas.index') }}">
                                {{ t('pieturas.create.back', 'Atpakaļ') }}
                        </x-primary-button>

                        <x-primary-button :spinner="true">
                                {{ t('pieturas.create.save', 'Izveidot') }}
                        </x-primary-button>
                    </div>
            </form>
        </div>
    </div>
</x-app-layout>
