<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-left items-center p-6">
                    {{ __("Ar šo pogu tiek sinhronizēti visi MP3 faili, ja pieturām ir mainījies teksts!") }}
                        <form method="POST" action="{{ route('mp3.sync') }}" x-data="{ syncing:false }" @submit="syncing=true" class="ml-4">
                            @csrf
                            <button type="submit"
                                    :disabled="syncing"
                                    class="inline-flex items-center px-4 py-2 rounded bg-blue-600 text-white disabled:opacity-60">
                                <span x-show="!syncing">{{ __('Sinhronizēt') }}</span>
                                <svg x-show="syncing" class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                                </svg>
                            </button>
                        </form>

                        @if(session('success'))
                        <div class="mt-3 text-green-600 font-medium">{{ session('success') }}</div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
