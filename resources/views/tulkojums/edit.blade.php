<x-app-layout>
    <div class="max-w-md mx-auto">
        <x-slot name="header">
            <h2 class="font-bold text-x dark:text-white">
                {{ t('tulkojums.edit.view', 'Rediģēt tulkojumu') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">

            <form
                method="POST"
                action="{{ route('tulkojums.update', [$valoda, $original]) }}"
                class="bg-white dark:bg-black rounded-lg">
                @csrf
                @method('PUT')

            <div class="grid grid-cols-1 gap-4 py-4 px-4">
                <strong class="dark:text-white">{{ t('tulkojums.edit.key', 'Atslēga') }}:</strong> <p class="text-gray-500">{{ $tulkojums->original->key }}</p>
                <strong class="dark:text-white">{{ t('tulkojums.edit.original', 'Oriģinālais teksts') }}:</strong> <p class="text-gray-500">{{ $tulkojums->original->text }}</p>

                <x-input-label :value="t('tulkojums.edit.translation', 'Tulkojums')" />
                <textarea name="translation"rows="4">{{ old('translation', $tulkojums->translation) }}</textarea>
                <x-input-error :messages="$errors->get('translation')" />
                    
                <div class="flex justify-between mt-4">
                    <x-primary-button href="{{ route('tulkojums.index', $valoda) }}">
                        {{ t('tulkojums.edit.back', 'Atpakaļ') }}
                    </x-primary-button>

                    <x-primary-button>
                        {{ t('tulkojums.edit.save', 'Saglabāt') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
