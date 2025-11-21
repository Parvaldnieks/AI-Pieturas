<x-app-layout>
    <div class="max-w-[600px] mx-auto">
        <x-slot name="header">
            <h2 class="font-bold text-xl dark:text-white">
                {{ t('mp3.index.view', 'MP3 Faili') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">
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
                class="bg-white dark:bg-black shadow rounded-lg p-6"
            >

                <input 
                    type="text" 
                    x-model="search"
                    placeholder="{{ t('mp3.index.search', 'Meklēt MP3 failus') }}..."
                    class="rounded w-full focus:border-orange-500 focus:ring-orange-500">

                <template x-if="filtered.length === 0">
                    <p class="text-center text-gray-500">
                        {{ t('mp3.index.empty', 'Nekas netika atrasts.') }}
                    </p>
                </template>

                <ul class="space-y-6" x-show="filtered.length > 0">
                    <template x-for="item in filtered" :key="item.id">
                        <li class="border-b border-orange-500">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-medium dark:text-white" 
                                    x-text="item.text">
                                    </p>
                                </div>

                                <template x-if="item.mp3_path">
                                    <audio 
                                        :src="`/storage/${item.mp3_path}`" 
                                        controls 
                                        preload="none" 
                                        class="w-64 mb-4">
                                    </audio>
                                </template>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
