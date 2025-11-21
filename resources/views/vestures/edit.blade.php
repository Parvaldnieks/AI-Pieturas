<x-app-layout>
    <div class="max-w-md mx-auto">
        <x-slot name="header">
            <h2 class="font-bold text-xl dark:text-white">
                {{ t('vestures.edit.view', 'Rediģēt Vēsturi') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">

            <form
                method="POST"
                action="{{ route('vestures.update', $vesture->id) }}"
                enctype="multipart/form-data"
                class="bg-white dark:bg-black shadow rounded-lg">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 py-4 px-4">
                        <x-input-label for="name" :value="t('vestures.edit.name', 'Nosaukums')" />
                        <x-text-input type="text" id="name" name="name" value="{{ old('name', $vesture->name) }}" />
                        <x-input-error :messages="$errors->get('name')" />

                        <x-input-label for="text" :value="t('vestures.edit.text', 'Teksts')" />
                        <x-text-input type="text" id="text" name="text" value="{{ old('text', $vesture->text) }}" />
                        <x-input-error :messages="$errors->get('text')" />

                        <x-input-label for="time" :value="t('vestures.edit.time', 'Laiks')" />
                        <x-text-input type="datetime-local" id="time" name="time" value="{{ old('time', $vesture->formatted_time ?? '') }}" />
                        <x-input-error :messages="$errors->get('time')" />

                        <x-input-label :value="t('vestures.edit.file', 'MP3 Fails')" />
                        <x-text-input type="file" name="file" accept=".mp3" />

                        @if($vesture->mp3_path)
                            <div>
                                <p>{{ t('vestures.edit.current', 'Pašreizējais fails:') }}</p>
                                <audio controls class="w-full">
                                    <source src="{{ asset('storage/'.$vesture->mp3_path) }}" type="audio/mpeg">
                                    Jūsu pārlūkprogramma neatbalsta audio atskaņošanu.
                                </audio>
                            </div>
                        @endif

                    <div class="flex justify-between">
                        <x-primary-button href="{{ route('vestures.index') }}">
                                {{ t('vestures.edit.back', 'Atpakaļ') }}
                        </x-primary-button>

                        <x-primary-button>
                                {{ t('vestures.edit.save', 'Saglabāt') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
