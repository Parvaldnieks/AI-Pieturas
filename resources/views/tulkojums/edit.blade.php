<x-app-layout>
    <div class="max-w-[500px] mx-auto p-4">

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                {{ t('tulkojums.edit.view', 'Rediģēt tulkojumu') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 mt-4 dark:border-none dark:bg-gradient-to-br 
                    from-black via-orange-500 to-black rounded-lg shadow-sm">
            <div class="bg-white dark:bg-black shadow rounded-lg p-6">

                <div class="dark:text-white mb-4">
                    <strong>{{ t('tulkojums.edit.key', 'Atslēga') }}:</strong> <p class="text-gray-500">{{ $tulkojums->original->key }}</p>

                    <strong>{{ t('tulkojums.edit.original', 'Oriģinālais teksts') }}:</strong> <p class="text-gray-500">{{ $tulkojums->original->text }}</p>
                </div>

                <form method="POST" action="{{ route('tulkojums.update', [$valoda, $original]) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label :value="t('tulkojums.edit.translation', 'Tulkojums')" />

                        <textarea 
                            name="translation"
                            rows="4"
                            class="w-full mt-1 p-2 rounded"
                        >{{ old('translation', $tulkojums->translation) }}</textarea>

                        <x-input-error :messages="$errors->get('translation')" class="mt-1" />
                    </div>

                    <div class="flex justify-between">
                        <x-primary-button href="{{ route('tulkojums.index', $valoda) }}">
                            {{ t('tulkojums.edit.back', 'Atpakaļ') }}
                        </x-primary-button>

                        <x-primary-button>
                            {{ t('tulkojums.edit.save', 'Saglabāt') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
