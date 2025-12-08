<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-white">
            {{ t('api.view', 'API Piekļuve') }}
        </h2>
    </x-slot>

    <div 
        x-data="{ 
            search: '', 
            requests: {{ $requests->toJson() }},
            get filtered() {
                if (this.search === '') return this.requests;
                return this.requests.filter(r =>
                    (r.device_type ?? '').toLowerCase().includes(this.search.toLowerCase()) ||
                    (r.device_os ?? '').toLowerCase().includes(this.search.toLowerCase()) ||
                    (r.email ?? '').toLowerCase().includes(this.search.toLowerCase()) ||
                    (r.status ?? '').toLowerCase().includes(this.search.toLowerCase())
                );
            }
        }"
    >

        <div class="max-w-md mx-auto flex flex-col mt-4">
            <input 
                type="text"
                x-model="search"
                placeholder="{{ t('api.search', 'Meklēt API pieprasījumus') }}..."
                class="border border-gray-300 rounded focus:border-orange-500 focus:ring-orange-500 p-2"
            >
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="min-w-full dark:text-white text-center border-collapse">
                <thead>
                    <tr class="border-b border-orange-500">
                        <th>{{ t('api.device.type', 'Ierīces Tips') }}</th>
                        <th>{{ t('api.device.os', 'Operētāj Sistēma') }}</th>
                        <th>{{ t('api.email', 'E-pasts') }}</th>
                        <th>{{ t('api.status', 'Status') }}</th>
                        <th>{{ t('api.key', 'API Atslēga') }}</th>
                        <th>{{ t('api.actions', 'Darbības') }}</th>
                    </tr>
                </thead>

                <tbody>
                    <template x-if="filtered.length === 0">
                        <tr>
                            <td colspan="6" class="text-gray-500 italic py-4">
                                {{ t('api.empty', 'Nekas netika atrasts.') }}
                            </td>
                        </tr>
                    </template>

                    @foreach($requests as $request)
                        <template x-if="filtered.some(r => r.id === {{ $request->id }})">
                            <tr class="border-b border-orange-500">
                                <td>{{ $request->device_type }}</td>
                                <td>{{ $request->device_os }}</td>
                                <td>{{ $request->email ?? '-' }}</td>

                                <td>
                                    @if($request->status === 'pending')
                                        <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">{{ t('api.pending', 'Gaida') }}</span>
                                    @elseif($request->status === 'approved')
                                        <span class="bg-green-200 text-green-800 px-2 py-1 rounded">{{ t('api.approved', 'Atļauts') }}</span>
                                    @else
                                        <span class="bg-red-200 text-red-800 px-2 py-1 rounded">{{ t('api.denied', 'Aizliegts') }}</span>
                                    @endif

                                    @if($request->blocked)
                                        <span class="bg-gray-700 text-white px-2 py-1 rounded ml-1">{{ t('api.blocked', 'Bloķēts') }}</span>
                                    @endif
                                </td>

                                <td>
                                    @if($request->apiKey)
                                        <code id="key-{{ $request->id }}">{{ $request->apiKey->key }}</code>
                                        <button onclick="navigator.clipboard.writeText(document.getElementById('key-{{ $request->id }}').innerText)"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded ml-1">
                                            {{ t('api.copy', 'Kopēt') }}
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if($request->status === 'pending' && !$request->blocked)
                                        <form method="POST" action="{{ url('/api/approve-access/'.$request->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                                {{ t('api.approve', 'Atļaut') }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ url('/api/deny-access/'.$request->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                {{ t('api.deny', 'Aizliegt') }}
                                            </button>
                                        </form>
                                    @endif

                                    @if($request->status === 'approved' && !$request->blocked)
                                        @if($request->apiKey)
                                            <form method="POST" action="{{ route('api.key.delete', $request->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">
                                                    {{ t('api.delete', 'Dzēst') }}
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ url('/api/approve-access/'.$request->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                                    {{ t('api.generate', 'Ģenerēt') }}
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                    @if(!$request->blocked)
                                        <form method="POST" action="{{ route('api.device.block', $request->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-3 py-1 rounded">
                                                {{ t('api.block', 'Bloķēt') }}
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('api.device.unblock', $request->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-3 py-1 rounded">
                                                {{ t('api.unblock', 'Atbloķēt') }}
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        </template>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
