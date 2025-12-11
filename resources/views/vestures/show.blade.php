<x-app-layout>
    <div class="max-w-md mx-auto">
        <x-slot name="header">
            <h2 class="font-bold text-xl dark:text-white">
                {{ t('vestures.show.view', 'MP3 Fails') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">

            <div class="bg-white dark:bg-black shadow rounded-lg p-4">
                <h3 class="dark:text-white text-lg font-bold">
                    {{ $vesture->text }}
                </h3>

                @if($vesture->mp3_path)
                    <div class="mt-4">
                        <audio controls preload="none" class="w-full">
                            <source src="{{ $vesture->pietura->latest_mp3_url }}" type="audio/mpeg">
                            Jūsu pārlūkprogramma neatbalsta audio atskaņošanu.
                        </audio>
                    </div>
                @endif

                <div class="flex justify-between mt-4">
                    <x-primary-button href="{{ route('vestures.index') }}">
                            {{ t('vestures.show.back', 'Atpakaļ') }}
                    </x-primary-button>

                    <x-primary-button href="{{ route('vestures.edit', $vesture->id) }}">
                            {{ t('vestures.show.edit', 'Rediģēt') }}
                    </x-primary-button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
