<x-app-layout>
        <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('Pieturas') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-6">
        <a class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300"
            href="{{ route('pieturas.create') }}">
            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-gray-100 rounded-md group-hover:bg-transparent">
                {{ __('Izveidot') }}
            </span>
        </a>
    </div>

    <x-pieturas-list :pieturas="$pieturas" />
</x-app-layout>
