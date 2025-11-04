<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('MP3 Faili') }}
        </h2>
    </x-slot>

    <div 
        x-data="{ 
            search: '', 
            mp3List: {{ $mp3->toJson() }},
            get filtered() {
                if (this.search === '') return this.mp3List;
                return this.mp3List.filter(item => 
                    (item.text ?? '').toLowerCase().includes(this.search.toLowerCase())
                );
            }
        }" 
        class="max-w-3xl mx-auto mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6"
    >

        <input 
            type="text" 
            x-model="search"
            placeholder="Meklēt MP3 failus..."
            class="border border-gray-300 rounded px-3 py-2 w-full mb-6 focus:border-blue-500 focus:ring-blue-500"
        >

        <template x-if="filtered.length === 0">
            <p class="text-center text-gray-500 italic">
                {{ __('Nav atrastu MP3 failu.') }}
            </p>
        </template>

        <ul class="space-y-6" x-show="filtered.length > 0">
            <template x-for="item in filtered" :key="item.id">
                <li class="border-b border-gray-200 pb-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100" 
                               x-text="item.text ?? 'Bez teksta'">
                            </p>
                        </div>

                        <div class="mt-3 sm:mt-0">
                            <template x-if="item.mp3_path">
                                <audio 
                                    :src="`/storage/${item.mp3_path}`" 
                                    controls 
                                    preload="none" 
                                    class="w-64"
                                ></audio>
                            </template>
                            <template x-if="!item.mp3_path">
                                <p class="text-gray-400 italic text-sm">{{ __('Nav pievienots fails.') }}</p>
                            </template>
                        </div>
                    </div>
                </li>
            </template>
        </ul>
    </div>
</x-app-layout>
