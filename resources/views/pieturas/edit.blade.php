<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-white">
            {{ t('pieturas.edit.view', 'Rediģēt Pieturu') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4 flex flex-col items-center">
        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm">
            <form
                method="POST"
                action="{{ route('pieturas.update', $pietura->id) }}"
                enctype="multipart/form-data"
                class="bg-white dark:bg-black shadow rounded-lg w-[400px] p-2"
            >
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 py-4 px-4">
                        <x-input-label for="name" :value="t('pieturas.edit.name', 'Nosaukums')" />
                        <x-text-input type="text" id="name" name="name" value="{{ old('name', $pietura->name) }}" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                        <x-input-label for="text" :value="t('pieturas.edit.text', 'Teksts')" />
                        <x-text-input type="text" id="text" name="text" value="{{ old('text', $pietura->text) }}" />
                        <x-input-error :messages="$errors->get('text')" class="mt-2" />
                </div>

                <div class="flex justify-between py-4 px-4">
                    <x-primary-button href="{{ route('pieturas.index') }}">
                            {{ t('pieturas.edit.back', 'Atpakaļ') }}
                    </x-primary-button>

                    <x-primary-button>
                        {{ t('pieturas.edit.save', 'Saglabāt') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
