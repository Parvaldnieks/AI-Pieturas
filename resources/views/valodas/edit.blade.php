<x-app-layout>
    <div class="max-w-md mx-auto">
        <x-slot name="header">
            <h2 class="font-bold text-xl dark:text-white">
                {{ t('valodas.edit.view', 'Rediģēt valodu') }}
            </h2>
        </x-slot>

        <div class="p-[1px] border border-orange-500 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm mt-4">

                <form
                    method="POST"
                    action="{{ route('valodas.update', $valoda) }}"
                    class="bg-white dark:bg-black rounded-lg">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4 py-4 px-4">
                        <x-input-label for="name" :value="t('valodas.edit.name', 'Nosaukums')" />
                        <x-text-input id="name" name="name" type="text" value="{{ old('name', $valoda->name) }}" />
                        <x-input-error :messages="$errors->get('name')" />
  
                        <x-input-label for="code" :value="t('valodas.edit.code', 'Kods')" />

                        <x-text-input id="code" name="code" type="text" value="{{ old('code', $valoda->code) }}" />
                        <x-input-error :messages="$errors->get('code')" />
                    
                        <div class="flex justify-between mt-4">
                            <x-primary-button href="{{ route('valodas.index') }}">
                                    {{ t('valodas.edit.back', 'Atpakaļ') }}
                            </x-primary-button>

                            <x-primary-button>
                                {{ t('valodas.edit.update', 'Saglabāt') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>

        </div>
    </div>
</x-app-layout>
