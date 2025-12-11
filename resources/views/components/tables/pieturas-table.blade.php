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
    }">

    <div class="max-w-md mx-auto flex flex-col">
        <input 
            type="text"
            x-model="search"
            placeholder="{{ t('pieturas.index.search', 'Meklēt pieturas') }}..."
            class="border border-gray-300 rounded focus:border-orange-500 focus:ring-red-500 mt-4">

        @if (auth()->user()->hasPermission('izveidot_pieturas'))
            <div class="flex justify-center mt-4">
                <x-primary-button 
                    type="button" 
                    @click="showMine = !showMine">
                    <span x-text="showMine ? visas : manas"></span>
                </x-primary-button>
            </div>
        @endif
    </div>

    <div class="overflow-x-auto mt-4">
        <table class="min-w-full dark:text-white text-center">
            <thead>
                <tr class="border-b border-orange-500">
                    <th class="px-4">{{ t('pieturas.index.name', 'Nosaukums') }}</th>
                    <th>{{ t('pieturas.index.audio', 'Atskaņot') }}</th>
                    <th class="px-4">{{ t('pieturas.index.text', 'Teksts') }}</th>
                    @if (auth()->user()->hasPermission('izveidot_pieturas'))
                        <template x-if="showMine || {{ $admin ? 'true' : 'false' }}">
                            <th class="px-4">{{ t('pieturas.index.actions', 'Darbības') }}</th>
                        </template>
                    @endif
                </tr>
            </thead>

            <tbody>
                <template x-if="filtered.length === 0">
                    <tr>
                        <td colspan="4" class="text-gray-500 italic text-center">
                            {{ t('pieturas.index.empty', 'Nekas netika atrasts.') }}
                        </td>
                    </tr>
                </template>

                <template x-for="pietura in filtered" :key="pietura.id">
                    <tr class="border-b border-orange-500">

                        <td>
                            <a 
                                :href="`/pieturas/${pietura.id}`"
                                class="text-blue-500 hover:underline"
                                x-text="pietura.name">
                            </a>
                        </td>

                        <td class="flex justify-center items-center py-4">
                            <audio
                                :src="pietura.latest_mp3_url"
                                x-show="pietura.latest_mp3_url"
                                controls
                                preload="none"
                                class="w-64">
                            </audio>
                        </td>

                        <td x-text="pietura.text"></td>

                        @if (auth()->user()->hasPermission('izveidot_pieturas'))
                            <template x-if="showMine || {{ $admin ? 'true' : 'false' }}">
                                <td>
                                    <a
                                        :href="`/pieturas/${pietura.id}/edit`"
                                        class="text-yellow-500 hover:underline mr-2">
                                        {{ t('pieturas.index.edit', 'Rediģēt') }}
                                    </a>

                                    <form 
                                        :action="`/pieturas/${pietura.id}`" 
                                        method="POST" 
                                        class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button 
                                            type="submit"
                                            onclick="return confirm( '{{ t('pieturas.index.confirm', 'Dzēst šo pieturu?') }}' )"
                                            class="text-red-500 hover:underline">
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
</div>
