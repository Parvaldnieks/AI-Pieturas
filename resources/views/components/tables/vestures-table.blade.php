@props(['vestures', 'user'])

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
    }">

    <div class="max-w-md mx-auto flex flex-col mt-4">
        <input 
            type="text" 
            x-model="search"
            placeholder="{{ t('vestures.index.search', 'Meklēt vēsturi') }}..."
            class="rounded mb-4 w-full focus:border-orange-500 focus:ring-orange-500">

        <input 
            type="date" 
            id="date" 
            x-model="selectedDate"
            class="rounded w-full focus:border-orange-500 focus:ring-orange-500">
    </div>

    <table class="w-full dark:text-white text-center mt-4">
        <thead>
            <tr class="border-b border-orange-500">
                <th>{{ t('vestures.index.mp3', 'MP3 Fails') }}</th>
                <th>{{ t('vestures.index.text', 'Teksts') }}</th>
                <th>{{ t('vestures.index.actions', 'Darbības') }}</th>
            </tr>
        </thead>

        <tbody>
            <template x-if="filtered.length === 0">
                <tr>
                    <td colspan="3" class="text-gray-500 text-center italic py-4">
                        {{ t('vestures.index.empty', 'Nekas netika atrasts.') }}
                    </td>
                </tr>
            </template>

            <template x-for="vesture in filtered" :key="vesture.id">
                <tr class="border-b border-orange-500 h-12">
                    <td>
                        <template x-if="vesture.mp3_path">
                            <a 
                                :href="`/vestures/${vesture.id}`" 
                                class="text-blue-500 hover:underline">
                                {{ t('vestures.index.show', 'MP3 Fails') }}
                            </a>
                        </template>
                    </td>
                    
                    <td>
                        <a 
                            :href="`/vestures/${vesture.id}/edit`"
                            class="text-yellow-500 hover:underline"
                            x-text="vesture.text">
                        </a>
                    </td>

                    <td>
                        <form :action="`/vestures/${vesture.id}`" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                onclick="return confirm( '{{ t('vestures.index.confirm', 'Dzēst šo vēsturi?') }}' )"
                                class="text-red-500 hover:underline">
                                {{ t('vestures.index.delete', 'Dzēst') }}
                            </button>
                        </form>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>

</div>
