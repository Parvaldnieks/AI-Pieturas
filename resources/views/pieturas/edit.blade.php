<x-app-layout>
    <div class="max-w-md mx-auto">
        <x-slot name="header">
            <h2 class="font-bold text-xl dark:text-white">
                {{ t('pieturas.edit.view', 'Rediģēt Pieturu') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">

            <form
                method="POST"
                action="{{ route('pieturas.update', $pietura->id) }}"
                enctype="multipart/form-data"
                class="bg-white dark:bg-black rounded-lg">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 py-4 px-4">
                    <x-input-label for="name" :value="t('pieturas.edit.name', 'Nosaukums')" />
                    <x-text-input type="text" id="name" name="name" value="{{ old('name', $pietura->name) }}" />
                    <x-input-error :messages="$errors->get('name')" />

                    <x-input-label for="text" :value="t('pieturas.edit.text', 'Teksts')" />
                    <x-text-input type="text" id="text" name="text" value="{{ old('text', $pietura->text) }}" />
                    <x-input-error :messages="$errors->get('text')" />

                    <div class="flex justify-between">
                        <x-primary-button href="{{ route('pieturas.index') }}">
                                {{ t('pieturas.edit.back', 'Atpakaļ') }}
                        </x-primary-button>

                        <x-primary-button>
                            {{ t('pieturas.edit.save', 'Saglabāt') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>

        <div>
    </div>
</x-app-layout>
