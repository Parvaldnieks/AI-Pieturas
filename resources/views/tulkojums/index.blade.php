<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-white">
            {{ $valoda->name }} {{ t('tulkojums.index.view', 'Tulkojumi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">

            <div class="mb-4">
                <x-primary-button href="{{ route('valodas.index') }}">
                    {{ t('tulkojums.index.back', 'Atpakaļ') }}
                </x-primary-button>
            </div>

            <div class="p-[1px] border border-orange-500 mt-4 dark:border-none dark:bg-gradient-to-br from-black via-orange-500 to-black rounded-lg shadow-sm">
                <div class="bg-white dark:bg-black shadow rounded-lg p-4">
                    <table class="w-full text-left dark:text-white">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">{{ t('tulkojums.index.key', 'Atslēga') }}</th>
                                <th class="py-2">{{ t('tulkojums.index.original', 'Oriģināls') }}</th>
                                <th class="py-2">{{ t('tulkojums.index.translation', 'Tulkojums') }}</th>
                                <th class="py-2">{{ t('tulkojums.index.actions', 'Darbības') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($originals as $original)
                                <tr class="border-b">
                                    <td class="py-2 font-mono text-sm">{{ $original->key }}</td>
                                    <td class="py-2">{{ $original->text }}</td>
                                    <td class="py-2">{{ $original->tulkojumi->first()->translation ?? '' }}</td>

                                    <td class="py-2">
                                        <a 
                                            href="{{ route('tulkojums.edit', [$valoda, $original]) }}"
                                            class="text-yellow-600 hover:text-yellow-700"
                                        >
                                            {{ t('tulkojums.index.edit', 'Rediģēt') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
