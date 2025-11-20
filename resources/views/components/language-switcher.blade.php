@php
    $current = session('valoda', request()->cookie('lang', app()->getLocale()));
@endphp

<div class="flex items-center">
    <form method="POST" action="{{ route('valodas.maina') }}">
        @csrf

        <select name="language"
                onchange="this.form.submit()"
                class="mr-2 py-2 rounded-md border border-orange-500 dark:bg-black dark:text-white">

            <option value="lv" {{ $current === 'lv' ? 'selected' : '' }}>LV</option>

            @foreach($languages as $valoda)
                @continue($valoda->code === 'lv')
                <option value="{{ $valoda->code }}"
                    {{ $current === $valoda->code ? 'selected' : '' }}>
                    {{ strtoupper($valoda->code) }}
                </option>
            @endforeach
        </select>
    </form>
</div>
