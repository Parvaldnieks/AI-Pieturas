@props(['valodas', 'originals'])

<x-sync-progress :batch="session('last_batch')" />

<div 
    x-data="{ 
        search: '',
        valodas: {{ $valodas->toJson() }},
        total: {{ $originals }},

        get filtered() {
            return this.valodas.filter(v => {
                const s = this.search.toLowerCase();
                return v.name.toLowerCase().includes(s) || v.code.toLowerCase().includes(s);
            });
        }
    }">

    <div class="max-w-md mx-auto flex flex-col">
        <input 
            type="text" 
            x-model="search"
            placeholder="{{ t('valodas.index.search', 'Meklēt valodas') }}..."
            class="rounded w-full focus:border-orange-500 focus:ring-orange-500 mt-4">
    </div>

    <table class="w-full dark:text-white text-center mt-4">
        <thead>
            <tr class="border-b border-orange-500">
                <th>{{ t('valodas.index.name', 'Nosaukums') }}</th>
                <th>{{ t('valodas.index.code', 'Kods') }}</th>
                <th>{{ t('valodas.index.actions', 'Darbības') }}</th>
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

            <template x-for="valoda in filtered" :key="valoda.id">
                <tr class="border-b border-orange-500">

                    <td class="p-2">
                        <a :href="`/valodas/${valoda.id}/tulkojums`"
                            class="text-blue-500 hover:underline"
                            x-text="valoda.name">
                        </a>
                    </td>

                    <td x-text="valoda.code"></td>

                    <td class="space-x-2">
                        <template x-if="(total - valoda.translated_count) > 0 && valoda.code !== 'lv'">
                            <form
                                :action="`/valodas/${valoda.id}/sync`"
                                method="POST"
                                class="inline">
                                @csrf

                                <button
                                    type="submit"
                                    onclick="return confirm('{{ t('valodas.index.confirm.sync', 'Sinhronizēt šo valodu?') }}')"
                                    class="text-blue-500 hover:underline">
                                    {{ t('valodas.index.sync', 'Sinhronizēt') }}
                                </button>
                            </form>
                        </template>

                        <a 
                            :href="`/valodas/${valoda.id}/edit`"
                            class="text-yellow-500 hover:underline">
                            {{ t('valodas.index.edit', 'Rediģēt') }}
                        </a>

                        <form
                            :action="`/valodas/${valoda.id}`"
                            method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button
                                onclick="return confirm('{{ t('valodas.index.confirm.delete', 'Dzēst šo valodu?') }}')"
                                class="text-red-500 hover:underline">
                                {{ t('valodas.index.delete', 'Dzēst') }}
                            </button>
                        </form>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
