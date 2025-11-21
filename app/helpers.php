<?php

use App\Models\Valodas;
use App\Models\Originals;
use App\Models\Tulkojums;

if (! function_exists('t')) {
    function t($key, $defaultText = null)
    {
        $lang = app()->getLocale();

        $original = Originals::firstOrCreate(
            ['key' => $key],
            ['text' => $defaultText ?? $key]
        );

        if ($lang === 'original') {
            return $original->text;
        }

        $valoda = Valodas::where('code', $lang)->first();

        if (! $valoda) {
            return $original->text;
        }

        $tulkojums = Tulkojums::where('originals_id', $original->id)
                              ->where('valodas_id', $valoda->id)
                              ->first();

        return $tulkojums->translation ?? $original->text;
    }
}
