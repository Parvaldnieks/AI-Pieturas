<x-app-layout class="max-w-md mx-auto">
    <div class="container mx-auto p-4 flex flex-col items-center" x-data="{ submitting: false }">
        <x-slot name="header">
            <h2 class="font-semibold text-xl">
                {{ __('Izveidot Pieturu') }}
            </h2>
        </x-slot>

        <form 
            method="POST" 
            action="{{ route('pieturas.store') }}" 
            enctype="multipart/form-data"
            x-on:submit="submitting = true"
            class="bg-white shadow rounded-lg mt-6 w-[400px]"
        >
            @csrf

                <div class="grid grid-cols-1 gap-4 py-4 px-4">
                    <x-input-label for="name" :value="__('Nosaukums')" />
                    <x-text-input type="text" id="name" name="name" />
                        @error('name')
                            <p class="text-center text-sm text-red-500">{{ $message }}</p>
                        @enderror

                    <x-input-label for="text" :value="__('Teksts')" />
                    <x-text-input type="text" id="text" name="text" />
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

                    <button 
                        type="submit"
                        :disabled="submitting"
                        x-bind:class="{ 'opacity-50 cursor-not-allowed': submitting }"
                        class="relative p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300"
                    >
                        <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white rounded-md group-hover:bg-transparent flex items-center justify-center">
                            <span x-show="!submitting">{{ __('Saglabāt') }}</span>

                            <svg 
                                x-show="submitting"
                                class="animate-spin h-5 w-5 text-purple-600 dark:text-purple-400"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle 
                                    class="opacity-25" 
                                    cx="12" cy="12" r="10" 
                                    stroke="currentColor" 
                                    stroke-width="4"
                                ></circle>
                                <path 
                                    class="opacity-75" 
                                    fill="currentColor" 
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                ></path>
                            </svg>
                        </span>
                    </button>
                </div>
        </form>
    </div>
</x-app-layout>
