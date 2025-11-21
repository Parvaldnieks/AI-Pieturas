@props(['users'])

@php
    $yes = t('users.index.yes', 'Jā');
    $no  = t('users.index.no', 'Nē');
@endphp

<div 
    x-data="{ 
        search: '', 
        yes: @js($yes),
        no: @js($no),
        users: {{ $users->toJson() }},
        get filtered() {
            if (this.search === '') return this.users;
            return this.users.filter(u =>
                u.name.toLowerCase().includes(this.search.toLowerCase()) ||
                u.email.toLowerCase().includes(this.search.toLowerCase())
            );
        }
    }">

    <div class="max-w-md mx-auto flex flex-col">
        <input 
            type="text" 
            x-model="search"
            placeholder="{{ t('users.index.search', 'Meklēt lietotājus') }}..."
            class="rounded focus:border-orange-500 focus:ring-orange-500 mt-4">
    </div>

    <table class="w-full text-center dark:text-white mt-4">
        <thead>
            <tr class="border-b border-orange-500">
                <th>ID</th>
                <th>{{ t('users.index.name', 'Vārds')}}</th>
                <th>{{ t('users.index.email', 'E-pasts') }}</th>
                <th>{{ t('users.index.admin', 'Administrators') }}</th>
                <th>{{ t('users.index.actions', 'Darbības') }}</th>
            </tr>
        </thead>

        <tbody>
            <template x-if="filtered.length === 0">
                <tr>
                    <td colspan="5" class="text-gray-500 text-center italic py-4">
                        {{ t('users.index.empty', 'Nekas netika atrasts.' ) }}
                    </td>
                </tr>
            </template>

            <template x-for="user in filtered" :key="user.id">
                <tr class="border-b border-orange-500 h-12">
                    <td x-text="user.id"></td>
                    
                    <td>
                        <a 
                            :href="`/users/${user.id}`"
                            class="text-blue-500 hover:underline"
                            x-text="user.name"
                        ></a>
                    </td>

                    <td x-text="user.email"></td>

                    <td x-text="user.admin ? yes : no"></td>

                    <td>
                        <a 
                            :href="`/users/${user.id}/edit`"
                            class="text-yellow-500 hover:underline mr-2"
                        >
                            {{ t('users.index.edit', 'Rediģēt') }}
                        </a>

                        <form 
                            :action="`/users/${user.id}`" 
                            method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')

                            <button 
                                type="submit" 
                                onclick="return confirm( '{{ t('users.index.confirm', 'Dzēst šo lietotāju?') }}' )"
                                class="text-red-500 hover:underline">
                                {{ t('users.index.delete', 'Dzēst') }}
                            </button>
                        </form>
                    </td>
                </tr>
            </template>

        </tbody>
    </table>
</div>
