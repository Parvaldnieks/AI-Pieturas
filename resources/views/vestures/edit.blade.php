<x-app-layout class="flex items-center justify-center">
    <div class="max-w-md mx-auto mt-6 p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rediģēt Vēsturi') }}
            </h2>
        </x-slot>

        <form method="POST" action="{{ route('vestures.update', $vesture->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">{{ __('Teksts') }}</label>
                    <input type="text" id="text" name="text" class="block mt-1 w-full rounded-md border-gray-200 dark:border-gray-600 dark:bg-gray-800 focus:border-purple-500 dark:focus:border-purple-500 focus:outline-none focus:ring-0 sm:text-sm" value="{{ old('name', $vesture->text) }}">
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-300">{{ __('Laiks') }}</label>
                    <input type="number" id="time" name="time" class="block mt-1 w-full rounded-md border-gray-200 dark:border-gray-600 dark:bg-gray-800 focus:border-purple-500 dark:focus:border-purple-500 focus:outline-none focus:ring-0 sm:text-sm" value="{{ old('name', $vesture->time) }}">
                </div>

                <div class="mt-6">
                    <label class="block text-gray-700 dark:text-gray-300 mb-1">{{ __('MP3 Fails') }}</label>
                    <input 
                        type="file" 
                        name="file" 
                        accept=".mp3" 
                        class="block w-full text-sm text-gray-700 dark:text-gray-300 border border-gray-300 rounded-md cursor-pointer bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    >

                    @if($vesture->mp3_path)
                        <div class="mt-3">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Pašreizējais fails:') }}</p>
                            <audio controls class="mt-1 w-full">
                                <source src="{{ asset('storage/'.$vesture->mp3_path) }}" type="audio/mpeg">
                                Jūsu pārlūkprogramma neatbalsta audio atskaņošanu.
                            </audio>
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    <button type="submit" class="relative inline-flex w-full items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <span class="relative px-5 py-2.5 transition-all ease-in duration-75 w-full bg-gray-100 rounded-md group-hover:bg-transparent">
                            {{ __('Saglabāt') }}
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

