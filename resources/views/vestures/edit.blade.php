<x-app-layout class="flex items-center justify-center">
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('Rediģēt Vēsturi') }}
        </h2>
    </x-slot>

    <div class="max-w-md mx-auto mt-6 p-4 bg-white shadow rounded-lg">
        <form
            method="POST"
            action="{{ route('vestures.update', $vesture->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-2">
                    <x-input-label for="name" :value="__('Nosaukums')" />
                    <x-text-input type="text" id="name" name="name" value="{{ old('name', $vesture->name) }}" />
                    @error('name')
                        <p class="text-center text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <x-input-label for="text" :value="__('Teksts')" />
                    <x-text-input type="text" id="text" name="text" value="{{ old('name', $vesture->text) }}" />
                    @error('text')
                        <p class="text-center text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <x-input-label for="time" :value="__('Laiks')" />
                    <x-text-input type="datetime-local" id="time" name="time" value="{{ old('time', $vesture->formatted_time ?? '') }}" />
                    @error('time')
                        <p class="text-center text-sm text-red-500">{{ $message }}</p>
                    @enderror

                <div class="mt-6">
                    <x-input-label :value="__('MP3 Fails')" />
                    <x-text-input type="file" name="file" accept=".mp3" />

                    @if($vesture->mp3_path)
                        <div>
                            <p class="text-sm text-gray-500">{{ __('Pašreizējais fails:') }}</p>
                            <audio controls class="mt-1 w-full">
                                <source src="{{ asset('storage/'.$vesture->mp3_path) }}" type="audio/mpeg">
                                Jūsu pārlūkprogramma neatbalsta audio atskaņošanu.
                            </audio>
                        </div>
                    @endif
                </div>

                <div class="flex justify-between">
                    <a class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300"
                        href="{{ route('vestures.index') }}">
                        <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-transparent">
                            {{ __('Atpakaļ') }}
                        </span>
                    </a>

                    <button type="submit" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-transparent">
                            {{ __('Saglabāt') }}
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
