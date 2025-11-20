<x-app-layout>
    <div class="container max-w-[500px] mx-auto p-4">
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-white">
            {{ t('vestures.show.view', 'MP3 Fails') }}
        </h2>
    </x-slot>

    <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm">
        <div class="p-6 bg-white dark:bg-black shadow rounded-lg">
            <h3 class="dark:text-white text-lg font-semibold">
                {{ $vesture->text }}
            </h3>

            @if($vesture->mp3_path)
                <div class="mt-4">
                    <audio controls preload="none" class="mt-2 w-full">
                        <source src="{{ asset('storage/'.$vesture->mp3_path) }}" type="audio/mpeg">
                        Jūsu pārlūkprogramma neatbalsta audio atskaņošanu.
                    </audio>
                </div>
            @else
                <p class="text-gray-400 italic mt-4">{{ __('Nav pievienots MP3 fails!') }}</p>
            @endif

            <div class="flex justify-between mt-6">
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
