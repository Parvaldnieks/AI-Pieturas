@props(['vestures'])

<div 
    x-data="{ 
        search: '', 
        vestures: {{ $vestures->toJson() }},
        get filtered() {
            if (this.search === '') return this.vestures;
            return this.vestures.filter(v => 
                v.text.toLowerCase().includes(this.search.toLowerCase())
            );
        }
    }" 
    class="p-6"
>

    <input 
        type="text" 
        x-model="search"
        placeholder="Meklē vēsturi..."
        class="border border-gray-300 rounded px-3 py-2 w-full mb-4 focus:border-blue-500 focus:ring-blue-500"
    >

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
                    {{-- MP3 file link --}}
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
