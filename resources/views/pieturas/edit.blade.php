<x-app-layout class="max-w-md mx-auto p-6 bg-white shadow rounded-lg">
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('Rediģēt Pieturu') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4 flex flex-col items-center">

        <form
            method="POST"
            action="{{ route('pieturas.update', $pietura->id) }}"
            enctype="multipart/form-data"
            class="bg-white shadow rounded-lg mt-6 w-[400px]"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 py-4 px-4">
                    <x-input-label for="name" :value="__('Nosaukums')" />
                    <x-text-input type="text" id="name" name="name" value="{{ old('name', $pietura->name) }}" />
                    @error('name')
                        <p class="text-center text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <x-input-label for="text" :value="__('Teksts')" />
                    <x-text-input type="text" id="text" name="text" value="{{ old('name', $pietura->text) }}" />
                    @error('text')
                        <p class="text-center text-sm text-red-500">{{ $message }}</p>
                    @enderror
            </div>

            <div class="flex justify-between py-4 px-4">
                <a class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300"
                    href="{{ route('pieturas.index') }}">
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
        </form>
    </div>
</x-app-layout>
