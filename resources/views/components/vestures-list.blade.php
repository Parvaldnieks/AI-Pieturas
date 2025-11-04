@props(['vestures'])

<div 
    x-data="{ 
        search: '', 
        selectedDate: '',
        vestures: {{ $vestures->toJson() }},

        get filtered() {
            return this.vestures.filter(v => {
                const matchesSearch = v.text.toLowerCase().includes(this.search.toLowerCase());

                if (!this.selectedDate) return matchesSearch;
                const formattedDate = new Date(v.time * 1000)
                    .toISOString()
                    .slice(0, 10);

                return matchesSearch && formattedDate === this.selectedDate;
            });
        }
    }" 
    class="p-6"
>

    <div class="max-w-md mx-auto flex flex-col sm:flex-row sm:space-x-4">
        <input 
            type="text" 
            x-model="search"
            placeholder="Meklēt vēsturi..."
            class="border border-gray-300 rounded px-3 py-2 mb-4 w-full focus:border-blue-500 focus:ring-blue-500"
        >

        <input 
            type="date" 
            id="date" 
            x-model="selectedDate"
            class="border border-gray-300 rounded px-3 py-2 mb-4 w-full focus:border-blue-500 focus:ring-blue-500"
        />
    </div>

    <table class="w-full border-collapse text-center">
        <thead>
            <tr>
                <th class="border-b border-gray-200 py-2">{{ __('MP3 Fails') }}</th>
                <th class="border-b border-gray-200 py-2">{{ __('Teksts') }}</th>
                <th class="border-b border-gray-200 py-2">{{ __('Darbības') }}</th>
            </tr>
        </thead>

        <tbody>
            <template x-if="filtered.length === 0">
                <tr>
                    <td colspan="3" class="text-gray-500 italic text-center py-4">
                        Nekas netika atrasts.
                    </td>
                </tr>
            </template>

            <template x-for="vesture in filtered" :key="vesture.id">
                <tr>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <template x-if="vesture.mp3_path">
                            <a 
                                :href="`/vestures/${vesture.id}`" 
                                class="text-blue-500 hover:text-blue-700 hover:underline"
                            >
                                MP3 Fails
                            </a>
                        </template>

                        <template x-if="!vesture.mp3_path">
                            <span class="text-gray-400 italic">Nav pievienots</span>
                        </template>
                    </td>
                    
                    <td class="px-6 py-4 border-b border-gray-200">
                        <a 
                            :href="`/vestures/${vesture.id}/edit`"
                            class="text-blue-500 hover:text-blue-700 hover:underline"
                            x-text="vesture.text"
                        ></a>
                    </td>

                    <td class="px-6 py-4 border-b border-gray-200">
                        <form :action="`/vestures/${vesture.id}`" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 hover:underline">
                                Dzēst
                            </button>
                        </form>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
