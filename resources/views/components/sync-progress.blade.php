@props(['batch'])

@if ($batch)
<div 
    x-data="syncTracker('{{ $batch }}')"
    x-init="start()"
    x-show="visible"
    x-transition.opacity.duration.500ms
    class="p-4 mb-4 dark:bg-black bg-gray-100 rounded"
>

    <h3 class="font-semibold mb-2 text-lg dark:text-white">
        {{ t('sync.progress', 'Sinhronizācijas progress') }}
    </h3>

    <template x-if="loading">
        <p class="dark:text-white">{{ t('sync.loading', 'Notiek') }}...</p>
    </template>

    <template x-if="!loading">
        <div>
            <p class="dark:text-white mb-1">
                <span x-text="progress"></span>% 
                ( <span x-text="processed"></span> / <span x-text="total"></span> )
            </p>

            <div class="w-full bg-gray-300 dark:bg-gray-700 h-3 rounded">
                <div 
                    class="bg-orange-500 h-3 rounded"
                    :style="`width: ${progress}%`"
                ></div>
            </div>

            <template x-if="finished">
                <p class="mt-2 text-green-600">
                    {{ t('sync.done', 'Pabeigts!') }}
                </p>
            </template>
        </div>
    </template>
</div>
@endif
