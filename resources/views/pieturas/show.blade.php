<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pietura: ') }} {{ $pietura->name }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <div class="flex justify-between">
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                <strong>Nosaukums:</strong> {{ $pietura->name }}
            </p>

            @if($mp3->vestures && $mp3->vestures->isNotEmpty())
                @php
                    $latestVesture = $mp3->vestures->first();
                @endphp

                @if($latestVesture->mp3_path)
                    <div class="mb-6">
                        <a 
                            href="{{ route('mp3.download', $latestVesture->id) }}"
                            class="inline-block text-blue-500 hover:text-blue-700 hover:underline"
                        >
                            {{ __('Lejupielādēt MP3') }}
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 italic">{{ __('Fails nav atrasts!') }}</p>
                @endif
            @endif
        </div>

        <p class="text-gray-700 dark:text-gray-300 mb-4">
            <strong>Teksts:</strong> {{ $pietura->text }}
        </p>

        @if($pietura->vestures && $pietura->vestures->isNotEmpty())
            <h3 class="text-lg font-semibold mb-2 text-gray-800">Vēsture</h3>
            <ul class="list-disc ml-6 space-y-2">
                @php
                    $previous = null;
                @endphp

                    @foreach($pietura->vestures as $vesture)
                        @if($previous)
                            @if($vesture->name !== $previous->name)
                                <li class="text-gray-700 dark:text-gray-300">
                                    Nosaukums mainīts no 
                                    <strong>{{ $previous->name }}</strong> 
                                    uz 
                                    <strong>{{ $vesture->name }}</strong>
                                    <span class="text-sm text-gray-500">
                                        ({{ date('Y-m-d H:i:s', $vesture->time) }})
                                    </span>
                                </li>
                            @endif

                            @if($vesture->text !== $previous->text)
                                <li class="text-gray-700 dark:text-gray-300">
                                    Teksts mainīts no 
                                    <strong>{{ $previous->text }}</strong> 
                                    uz 
                                    <strong>{{ $vesture->text }}</strong>
                                    <span class="text-sm text-gray-500">
                                        ({{ date('Y-m-d H:i:s', $vesture->time) }})
                                    </span>
                                </li>
                            @endif

                        @else
                            <li class="text-gray-700 dark:text-gray-300">
                                Pietura izveidota ar nosaukumu 
                                <strong>{{ $vesture->name }}</strong> 
                                un tekstu 
                                <strong>{{ $vesture->text }}</strong>
                                <span class="text-sm text-gray-500">
                                    ({{ date('Y-m-d H:i:s', $vesture->time) }})
                                </span>
                            </li>
                        @endif

                        @php
                            $previous = $vesture;
                        @endphp

                    @endforeach
                    @endif
            </ul>

        <div class="mt-6">
            <a class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300"
                href="{{ route('pieturas.index') }}">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-transparent">
                    {{ __('Atpakaļ') }}
                </span>
            </a>
        </div>
    </div>
</x-app-layout>
