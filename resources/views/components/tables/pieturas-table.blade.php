@props(['pieturas', 'user', 'admin'])

@php
    $manas = t('pieturas.index.mine', 'Manas');
    $visas = t('pieturas.index.all', 'Visas');
@endphp

<div 
    x-data="{ 
        search: '', 
        showMine: false,
        user: {{ $user }},
        pieturas: {{ $pieturas->toJson() }},
        manas: @js($manas),
        visas: @js($visas),
        get filtered() {
            let list = this.pieturas;

            if (this.showMine) {
                list = list.filter(p => p.user_id === this.user);
            }

            if (this.search !== '') {
                list = list.filter(p =>
                    p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    p.text.toLowerCase().includes(this.search.toLowerCase())
                );
            }

            return list;
        }
    }"
    class="p-6"
>

    <div class="max-w-md mx-auto flex flex-col sm:flex-row sm:space-x-4 mb-4">
        <input 
            type="text" 
            x-model="search"
            placeholder="{{ t('pieturas.index.search', 'Meklēt pieturas') }}..."
            class="border border-gray-300 rounded px-2 py-2 focus:border-orange-500 focus:ring-red-500"
        >

        @if (auth()->user()->hasPermission('izveidot_pieturas'))
            <div>
                <x-primary-button 
                    type="button" 
                    @click="showMine = !showMine"
                >
                    <span x-text="showMine ? visas : manas"></span>
                </x-primary-button>
            </div>
        @endif
    </div>

    <table class="w-full border-collapse text-center">
        <thead>
            <tr class="dark:text-white border-b border-orange-500">
                <th>{{ t('pieturas.index.name', 'Nosaukums') }}</th>
                <th>{{ t('pieturas.index.audio', 'Atskaņot') }}</th>
                <th>{{ t('pieturas.index.text', 'Teksts') }}</th>
                @if (auth()->user()->hasPermission('izveidot_pieturas'))
                    <template x-if="showMine || {{ $admin ? 'true' : 'false' }}">
                        <th>{{ t('pieturas.index.actions', 'Darbības') }}</th>
                    </template>
                @endif
            </tr>
        </thead>

        <tbody>
            <template x-if="filtered.length === 0">
                <tr>
                    <td colspan="4" class="text-gray-500 italic text-center py-4">
                        {{ t('pieturas.index.empty', 'Nekas netika atrasts.') }}
                    </td>
                </tr>
            </template>

            <template x-for="pietura in filtered" :key="pietura.id">
                <tr class="border-b border-orange-500 dark:text-white">

                    <td class="h-24">
                        <a 
                            :href="`/pieturas/${pietura.id}`"
                            class="text-blue-500 hover:text-blue-700 hover:underline"
                            x-text="pietura.name"
                        ></a>
                    </td>

                    <td>
                        <audio
                            :src="pietura.latest_mp3_path ? `/storage/${pietura.latest_mp3_path}` : ''"
                            x-show="pietura.latest_mp3_path"
                            controls
                            preload="none"
                            class="w-64">
                        </audio>
                    </td>

                    <td x-text="pietura.text"></td>

                    @if (auth()->user()->hasPermission('izveidot_pieturas'))
                        <template x-if="showMine || {{ $admin ? 'true' : 'false' }}">
                            <td class="space-x-3">
                                <a 
                                    :href="`/pieturas/${pietura.id}/edit`"
                                    class="text-yellow-500 hover:text-yellow-700 hover:underline"
                                >
                                    {{ t('pieturas.index.edit', 'Rediģēt') }}
                                </a>

                                <form 
                                    :action="`/pieturas/${pietura.id}`" 
                                    method="POST" 
                                    class="inline-block"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        onclick="return confirm( '{{ t('pieturas.index.confirm', 'Dzēst šo pieturu?') }}' )"
                                        class="text-red-500 hover:text-red-700 hover:underline"
                                    >
                                        {{ t('pieturas.index.delete', 'Dzēst') }}
                                    </button>
                                </form>
                            </td>
                        </template>
                    @endif
                </tr>
            </template>
        </tbody>
    </table>
</div>
