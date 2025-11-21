<x-app-layout>
    <div class="max-w-md mx-auto">
        <x-slot name="header">
            <h2 class="font-bold text-xl dark:text-white">
                {{ t('users.edit.view', 'Rediģēt Lietotāju') }}
            </h2>
        </x-slot>
    
        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">

            <form
                method="POST" 
                action="{{ route('users.update', $user) }}"
                enctype="multipart/form-data"
                class="bg-white dark:bg-black rounded-lg">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 py-4 px-4">
                    <x-input-label for="name" :value="t('users.edit.name', 'Vārds')" />
                    <x-text-input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"/>
                    <x-input-error :messages="$errors->get('name')" />

                    <x-input-label for="email" :value="t('users.edit.email', 'E-pasts')" />
                    <x-text-input id="email" name="email" value="{{ old('email', $user->email) }}"/>
                    <x-input-error :messages="$errors->get('email')" />

                    <x-input-label for="password" :value="t('users.edit.password', 'Parole (var nemainīt)')" />
                    <x-text-input id="password" name="password" type="password" autocomplete="new-password"/>
                    <x-input-error :messages="$errors->get('password')" />

                    <label class="inline-flex items-center">
                        <input 
                            type="checkbox" 
                            name="admin" 
                            class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                            {{ $user->admin ? 'checked' : '' }}>
                        <span class="ml-2 dark:text-white">{{ t('users.edit.admin', 'Administrators') }}</span>
                    </label>     

                    <h2 class="text-lg font-bold mb-2 dark:text-white">{{ t('users.edit.permissions', 'Privilēģijas') }}</h2>
                    <div class="bg-white dark:bg-black rounded grid grid-cols-1 dark:text-white">
                        @foreach ($permissions as $permission)
                            <label>
                                <input 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $permission->id }}"
                                    {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                <span>{{ t('permission.' . $permission->name, $permission->name) }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex justify-between mt-4">
                        <x-primary-button href="{{ route('users.index') }}">
                            {{ t('users.edit.back', 'Atpakaļ') }}
                        </x-primary-button>

                        <x-primary-button>
                            {{ t('users.edit.save', 'Saglabāt') }}
                        </x-primary-button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</x-app-layout>
