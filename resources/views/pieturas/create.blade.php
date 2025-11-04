<x-app-layout class="max-w-md mx-auto">
<div class="container mx-auto p-4 flex flex-col items-center">
    <h1 class="text-3xl font-bold">{{ __('Izveidot Pieturu') }}</h1>

    <form method="POST" action="{{ route('pieturas.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300">{{ __('Nosaukums') }}</label>
                    <input type="text" id="name" name="name" class="block mt-1 w-full rounded-md border-gray-200 dark:border-gray-600 dark:bg-gray-800 focus:border-purple-500 dark:focus:border-purple-500 focus:outline-none focus:ring-0 sm:text-sm">
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-300">{{ __('Teksts') }}</label>
                    <input type="text" id="text" name="text" class="block mt-1 w-full rounded-md border-gray-200 dark:border-gray-600 dark:bg-gray-800 focus:border-purple-500 dark:focus:border-purple-500 focus:outline-none focus:ring-0 sm:text-sm">
                </div>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-gray-100 rounded-md group-hover:bg-transparent">
                        {{ __('Saglabāt') }}
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
</x-app-layout>
