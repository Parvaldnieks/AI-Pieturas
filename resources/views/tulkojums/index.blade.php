<x-app-layout>
    <div class="max-w-[1000px] mx-auto">
        <x-slot name="header">
            <h2 class="font-bold text-xl dark:text-white">
                {{ $valoda->name }} {{ t('tulkojums.index.view', 'Tulkojumi') }}
            </h2>
        </x-slot>

        <div class="flex justify-center mt-4">
            <x-primary-button href="{{ route('valodas.index') }}">
                {{ t('tulkojums.index.back', 'Atpakaļ') }}
            </x-primary-button>
        </div>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">
                <div
                    x-data="{
                        search: '',
                        group: '',
                        viewName: '',
                        field: '',
                        rows: @js($rows),

                        get groups() {
                            const set = new Set(
                                this.rows
                                    .map(r => r.group)
                                    .filter(g => g && g.length)
                            );
                            return Array.from(set).sort();
                        },

                        get views() {
                            const set = new Set(
                                this.rows
                                    .filter(r => !this.group || r.group === this.group)
                                    .map(r => r.view)
                                    .filter(v => v && v.length)
                            );
                            return Array.from(set).sort();
                        },

                        get fields() {
                            const set = new Set(
                                this.rows
                                    .filter(r => (!this.group || r.group === this.group) &&
                                                (!this.viewName || r.view === this.viewName))
                                    .map(r => r.field)
                                    .filter(f => f && f.length)
                            );
                            return Array.from(set).sort();
                        },

                        get filtered() {
                            const s = this.search.toLowerCase();

                            return this.rows.filter(r => {
                                if (this.group && r.group !== this.group) return false;
                                if (this.viewName && r.view !== this.viewName) return false;
                                if (this.field && r.field !== this.field) return false;

                                if (!s) return true;

                                return (
                                    r.key.toLowerCase().includes(s) ||
                                    r.original.toLowerCase().includes(s) ||
                                    (r.translation || '').toLowerCase().includes(s)
                                );
                            });
                        }
                    }"
                >

                    <div class="bg-white dark:bg-black rounded-lg p-4 sticky top-0 z-20 shadow-md">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                            <input
                                type="text"
                                x-model="search"
                                placeholder="{{ t('tulkojums.index.search', 'Meklēt tulkojumus') }}..."
                                class="rounded px-3 py-2 w-full focus:border-orange-500 focus:ring-orange-500"
                            >

                            <select
                                x-model="group"
                                class="rounded px-3 py-2 w-full focus:border-orange-500 focus:ring-orange-500"
                            >
                                <option value="">{{ t('tulkojums.index.group.all', 'Visas grupas') }}</option>
                                <template x-for="g in groups" :key="g">
                                    <option :value="g" x-text="g"></option>
                                </template>
                            </select>

                            <select
                                x-model="viewName"
                                class="rounded px-3 py-2 w-full focus:border-orange-500 focus:ring-orange-500"
                            >
                                <option value="">{{ t('tulkojums.index.view.all', 'Visi skati') }}</option>
                                <template x-for="v in views" :key="v">
                                    <option :value="v" x-text="v"></option>
                                </template>
                            </select>

                            <select
                                x-model="field"
                                class="rounded w-full focus:border-orange-500 focus:ring-orange-500"
                            >
                                <option value="">{{ t('tulkojums.index.field.all', 'Visi lauki') }}</option>
                                <template x-for="f in fields" :key="f">
                                    <option :value="f" x-text="f"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full text-left dark:text-white">
                                <thead>
                                    <tr class="border-b border-orange-500">
                                        <th>{{ t('tulkojums.index.key', 'Atslēga') }}</th>
                                        <th>{{ t('tulkojums.index.original', 'Oriģināls') }}</th>
                                        <th>{{ t('tulkojums.index.translation', 'Tulkojums') }}</th>
                                        <th>{{ t('tulkojums.index.actions', 'Darbības') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <template x-if="filtered.length === 0">
                                        <tr>
                                            <td colspan="4" class="py-4 text-center text-gray-500 italic">
                                                {{ t('tulkojums.index.empty', 'Nekas netika atrasts.') }}
                                            </td>
                                        </tr>
                                    </template>

                                    <template x-for="row in filtered" :key="row.id">
                                        <tr class="border-b border-orange-500">
                                            <td class="p-2" x-text="row.key"></td>
                                            <td x-text="row.original"></td>
                                            <td x-text="row.translation"></td>

                                            <td>
                                                <a
                                                    :href="`/valodas/{{ $valoda->id }}/tulkojums/${row.id}/edit`"
                                                    class="text-yellow-500 hover:underline"
                                                >
                                                    {{ t('tulkojums.index.edit', 'Rediģēt') }}
                                                </a>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
