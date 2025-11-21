<x-app-layout>
    <div class="max-w-md mx-auto" x-data="{ submitting: false }">
        <x-slot name="header">
            <h2 class="font-bold text-xl dark:text-white">
                {{ t('pieturas.create.view', 'Izveidot Pieturu') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">

            <form
                method="POST" 
                action="{{ route('pieturas.store') }}" 
                enctype="multipart/form-data"
                x-on:submit="submitting = true"
                class="bg-white dark:bg-black rounded-lg">
                @csrf

                <div class="grid grid-cols-1 gap-4 py-4 px-4">
                        <x-input-label for="name" :value="t('pieturas.create.name', 'Nosaukums')" />
                        <x-text-input type="text" id="name" name="name" value="{{ old('name') }}"/>
                        <x-input-error :messages="$errors->get('name')" />

                        <x-input-label for="text" :value="t('pieturas.create.text', 'Teksts')" />
                        <x-text-input type="text" id="text" name="text" value="{{ old('text') }}"/>
                        <x-input-error :messages="$errors->get('text')" />

                    <div class="flex justify-between">
                        <x-primary-button href="{{ route('pieturas.index') }}">
                                {{ t('pieturas.create.back', 'Atpakaļ') }}
                        </x-primary-button>

                        <x-primary-button :spinner="true">
                                {{ t('pieturas.create.save', 'Izveidot') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
