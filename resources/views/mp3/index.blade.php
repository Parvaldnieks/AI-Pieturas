<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vēstures MP3 faili') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        @if($mp3->isEmpty())
            <p class="text-center text-gray-500 italic">
                {{ __('Nav pievienotu MP3 failu vēsturē.') }}
            </p>
        @else
            <ul class="space-y-6">
                @foreach($mp3 as $item)
                    <li class="border-b border-gray-200 pb-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item->text ?? 'Bez teksta' }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Laiks:') }} {{ $item->time }}
                                </p>
                            </div>

                            <div class="mt-3 sm:mt-0">
                                <audio controls preload="none" class="w-64">
                                    <source src="{{ asset('storage/'.$item->mp3_path) }}" type="audio/mpeg">
                                    {{ __('Jūsu pārlūkprogramma neatbalsta audio atskaņošanu.') }}
                                </audio>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
