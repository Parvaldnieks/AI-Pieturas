<div 
    x-data="{ 
        search: '', 
        pieturas: {{ $pieturas->toJson() }},
        get filtered() {
            if (this.search === '') return this.pieturas;
            return this.pieturas.filter(p => 
                p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                p.text.toLowerCase().includes(this.search.toLowerCase())
            );
        }
    }"
    class="p-6"
>

    <input 
        type="text" 
        x-model="search"
        placeholder="Search pieturas..."
        class="border border-gray-300 rounded px-3 py-2 w-full mb-4 focus:border-blue-500 focus:ring-blue-500"
    >

    <table class="w-full border-collapse text-center">
        <thead>
            <tr>
                <th class="py-3 border-b border-gray-200">{{ __('Nosaukums') }}</th>
                <th class="border-b border-gray-200">{{ __('Teksts') }}</th>
                <th class="border-b border-gray-200">{{ __('Darbības') }}</th>
            </tr>
        </thead>

        <tbody>
            <template x-if="filtered.length === 0">
                <tr>
                    <td colspan="3" class="text-gray-500 italic text-center py-4">
                        No results found.
                    </td>
                </tr>
            </template>

            <template x-for="pietura in filtered" :key="pietura.id">
                <tr>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <a 
                            :href="`/pieturas/${pietura.id}/edit`"
                            class="text-blue-500 hover:text-blue-700 hover:underline"
                            x-text="pietura.name"
                        ></a>
                    </td>

                    <td class="px-6 py-4 border-b border-gray-200" x-text="pietura.text"></td>

                    <td class="px-6 py-4 border-b border-gray-200">
                        <form :action="`/pieturas/${pietura.id}`" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 hover:underline">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
            </template>
        </tbody>
    </table>
</div>
