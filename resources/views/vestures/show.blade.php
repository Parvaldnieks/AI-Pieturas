<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('MP3 Fails') }}
        </h2>
    </x-slot>

    <div class="max-w-[500px] mx-auto mt-6 p-6 bg-white shadow rounded-lg">
        <h3 class="text-lg font-semibold">
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
            <a class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300"
                href="{{ route('vestures.index') }}">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-transparent">
                    {{ __('Atpakaļ') }}
                </span>
            </a>

            <a class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300"
                href="{{ route('vestures.edit', $vesture->id) }}">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-transparent">
                    {{ __('Rediģēt') }}
                </span>
            </a>
        </div>
    </div>
</x-app-layout>
