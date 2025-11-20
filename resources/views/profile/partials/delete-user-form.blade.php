<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ t('profile.edit.delete', 'Dzēst Kontu') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ t('profile.edit.delete.description', 'Izdzēšot kontu, tiks izdzēsti visi dati, kas jebkad ir bijuši saistīti ar to.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ t('profile.edit.delete.button', 'Dzēst Kontu') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ t('profile.edit.delete.confirm', 'Vai esat pārliecināts par konta dzēšanu?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ t('profile.edit.delete.confirm.description', 'Pēc konta dzēšanas tas vairs nebūs pieejams.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ t('profile.edit.delete.password', 'Parole') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ t('profile.edit.delete.password', 'Parole') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ t('profile.edit.delete.cancel', 'Atcelt') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ t('profile.edit.delete.delete', 'Dzēst Kontu') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
