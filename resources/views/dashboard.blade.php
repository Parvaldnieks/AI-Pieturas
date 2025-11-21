<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-white">
            {{ t('dashboard.view', 'Sākums') }}
        </h2>
    </x-slot>

    <div class="max-w-[1100px] mx-auto mt-4">    
        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm">
            <div class="bg-white dark:bg-black dark:text-white rounded-lg p-4">
                <div class="flex justify-left items-center">

                    @if (auth()->check() && auth()->user()->admin)
                        {{ t('dashboard.sync.text', 'Ar šo pogu tiek sinhronizēti visi MP3 faili, ja pieturām ir mainījies teksts!') }}

                        <form 
                            method="POST" 
                            action="{{ route('mp3.sync') }}" 
                            class="ml-4"
                            x-data="{ submitting: false }"
                            @submit="submitting = true"
                        >
                            @csrf
                            <x-primary-button spinner="true">
                                {{ t('dashboard.sync', 'Sinhronizēt') }}
                            </x-primary-button>
                        </form>

                        @if (session('success'))
                            <div 
                                x-data="{ show: true }" 
                                x-show="show" 
                                x-transition.opacity.duration.500ms 
                                x-init="setTimeout(() => show = false, 3000)" 
                                class="text-green-500 font-medium rounded px-2 py-2 ml-4"
                            >
                                {{ session('success') }}
                            </div>
                        @endif
                    @else
                        <p class="text-lg font-medium">
                            {{ t('dashboard.welcome', 'Sveiki') }}, {{ auth()->user()->name }}! {{ t('dashboard.welcome.text', 'Lai piekļūtu pilnajai tīmekļa vietnes versijai, jums ir jāsazinās ar administratoru.') }}
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <x-sync-progress :batch="session('last_batch')" />
</x-app-layout>
