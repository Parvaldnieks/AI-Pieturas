@props(['valodas'])

<div 
    x-data="{ 
        search: '',
        valodas: {{ $valodas->toJson() }},

        get filtered() {
            return this.valodas.filter(v => {
                const s = this.search.toLowerCase();
                return v.name.toLowerCase().includes(s) || v.code.toLowerCase().includes(s);
            });
        }
    }"
    class="p-6"
>

    <div class="max-w-md mx-auto mb-6">
        <input 
            type="text" 
            x-model="search"
            placeholder="{{ t('valodas.index.search', 'Meklēt valodas') }}..."
            class="rounded px-3 py-2 w-full focus:border-orange-500 focus:ring-orange-500"
        >
    </div>

    <div class="dark:bg-black rounded-lg text-center">
        <table class="w-full dark:text-white">
            <thead>
                <tr class="border-b border-orange-500">
                    <th class="py-2">{{ t('valodas.index.name', 'Nosaukums') }}</th>
                    <th class="py-2">{{ t('valodas.index.code', 'Kods') }}</th>
                    <th class="py-2">{{ t('valodas.index.actions', 'Darbības') }}</th>
                </tr>
            </thead>

            <tbody>
                <template x-if="filtered.length === 0">
                    <tr>
                        <td colspan="3" class="text-gray-500 italic py-4">
                            {{ t('valodas.index.empty', 'Nekas netika atrasts.') }}
                        </td>
                    </tr>
                </template>

                <template x-for="val in filtered" :key="val.id">
                    <tr class="border-b border-orange-500">

                        <td class="py-2">
                            <a :href="`/valodas/${val.id}/tulkojums`"
                               class="text-blue-600 hover:text-blue-700"
                               x-text="val.name">
                            </a>
                        </td>

                        <td class="py-2" x-text="val.code"></td>

                        <td class="py-2 space-x-3">

                            <template x-if="val.translation_count == 0 && val.code !== 'lv'">
                                <form
                                    :action="`/valodas/${val.id}/sync`"
                                    method="POST"
                                    class="inline"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        onclick="return confirm('{{ t('valodas.index.confirm.sync', 'Sinhronizēt šo valodu?') }}')"
                                        class="text-blue-600 hover:text-blue-700"
                                    >
                                        {{ t('valodas.index.sync', 'Sinhronizēt') }}
                                    </button>
                                </form>
                            </template>

                            <a 
                                :href="`/valodas/${val.id}/edit`"
                                class="text-yellow-600 hover:text-yellow-700"
                            >
                                {{ t('valodas.index.edit', 'Rediģēt') }}
                            </a>

                            <form
                                :action="`/valodas/${val.id}`"
                                method="POST"
                                class="inline"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('{{ t('valodas.index.confirm.delete', 'Dzēst šo valodu?') }}')"
                                    class="text-red-600 hover:text-red-700"
                                >
                                    {{ t('valodas.index.delete', 'Dzēst') }}
                                </button>
                            </form>

                        </td>
                    </tr>
                </template>

            </tbody>
        </table>
    </div>
</div>
