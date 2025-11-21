<x-app-layout>
    <div class="max-w-[800px] mx-auto">
        <x-slot name="header">
            <h2 class="font-bold text-xl dark:text-white">
                {{ t('pieturas.show.view', 'Pietura') }}: {{ $pietura->name }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">
            <div class="bg-white dark:bg-black shadow rounded-lg p-4">
                <div class="flex justify-between">
                    <p class="dark:text-white">
                        <strong>{{ t('pieturas.show.name', 'Nosaukums:') }}</strong> {{ $pietura->name }}
                    </p>

                    @if($mp3->vestures && $mp3->vestures->isNotEmpty())
                        @php
                            $latestVesture = $mp3->vestures->first();
                        @endphp

                        @if($latestVesture->mp3_path)
                            <div>
                                <a 
                                    href="{{ route('mp3.download', $latestVesture->id) }}"
                                    class="inline-block text-blue-500 hover:underline"
                                >
                                    {{ t('pieturas.show.download', 'Lejupielādēt MP3') }}
                                </a>
                            </div>
                        @else
                            <p class="text-gray-500">{{ __('Fails nav atrasts!') }}</p>
                        @endif
                    @endif
                </div>

                <p class="dark:text-white">
                    <strong>{{  t('pieturas.show.text', 'Teksts:') }}</strong> {{ $pietura->text }}
                </p>

                @if($pietura->vestures && $pietura->vestures->isNotEmpty())
                    <h3 class="text-lg font-bold dark:text-white mt-6">{{ t('pieturas.show.history', 'Vēsture') }}</h3>
                    <ul class="dark:text-white list-disc ml-6">

                            @foreach($pietura->vestures as $i => $current)
                                @php
                                    $older = $pietura->vestures[$i + 1] ?? null;
                                    $date  = date('d-m-Y H:i:s', $current->time);
                                @endphp

                                @if($older)
                                    @if($current->name !== $older->name)
                                    <li>
                                        {{ t('pieturas.show.history.edit.old.name', 'Nosaukums mainīts no') }}
                                        <strong class="underline">{{ $older->name }}</strong>

                                        {{ t('pieturas.show.history.edit.new.name', 'uz') }}
                                        <strong class="underline">{{ $current->name }}</strong>
                                        <span class="text-gray-500">({{ $date }})</span>
                                    </li>
                                    @endif

                                    @if($current->text !== $older->text)
                                    <li>
                                        {{ t('pieturas.show.history.edit.old.text', 'Teksts mainīts no') }}
                                        <strong class="underline">{{ $older->text }}</strong>
                                        
                                        {{ t('pieturas.show.history.edit.new.text', 'uz') }}
                                        <strong class="underline">{{ $current->text }}</strong>
                                        <span class="text-gray-500">({{ $date }})</span>
                                    </li>
                                    @endif
                                @else
                                    <li>
                                        {{ t('pieturas.show.history.created.name', 'Pietura izveidota ar nosaukumu') }}
                                        <strong class="underline"><span>{{ $current->name }}</span></strong>

                                        {{ t('pieturas.show.history.created.text', 'un tekstu') }}
                                        <strong class="underline"><span>{{ $current->text }}</span></strong>
                                        <span class="text-gray-500">({{ $date }})</span>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>

                <x-primary-button href="{{ route('pieturas.index') }}" class="mt-6">
                    {{ t('pieturas.show.back', 'Atpakaļ') }}
                </x-primary-button>
            </div>
        </div>
    </div>
</x-app-layout>
