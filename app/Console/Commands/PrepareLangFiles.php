<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OpenAITranslator;
use Illuminate\Support\Facades\File;

class PrepareLangFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:prepare {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepares Laravels lang files to a target language code';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lang = strtolower($this->argument('code'));

        $base = base_path('lang/en');
        $target = base_path("lang/$lang");

        if (!File::exists($base)) {
            $this->error("Base directory /lang/en does not exist.");
            return Command::FAILURE;
        }

        if (!File::exists($target)) {
            File::makeDirectory($target, 0755, true);
            $this->info("Created folder: lang/$lang");
        }

        $files = File::allFiles($base);

        foreach ($files as $file) {
            $array = include $file->getPathname();

            $empty = $this->emptyLangArray($array);

            $content = "<?php\n\nreturn " . $this->arrayToPhp($empty) . ";\n";

            File::put("$target/{$file->getFilename()}", $content);

            $this->info("Created: lang/$lang/{$file->getFilename()}");
        }

        $this->info("Language '$lang' prepared successfully!");
        return Command::SUCCESS;
    }

    private function arrayToPhp(array $array, int $indent = 0): string
    {
        $indentStr = str_repeat('    ', $indent);
        $nextIndentStr = str_repeat('    ', $indent + 1);

        $php = "[\n";

        foreach ($array as $key => $value) {
            $keyStr = var_export($key, true);

            if (is_array($value)) {
                $valueStr = $this->arrayToPhp($value, $indent + 1);
                $php .= "{$nextIndentStr}{$keyStr} => {$valueStr},\n";
            } else {
                $valueStr = var_export($value, true);
                $php .= "{$nextIndentStr}{$keyStr} => {$valueStr},\n";
            }
        }

        $php .= "{$indentStr}]";

        return $php;
    }

    private function emptyLangArray(array $array): array
    {
        $clean = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $clean[$key] = $this->emptyLangArray($value);
            } elseif (is_string($value)) {
                $clean[$key] = '';
            } else {
                $clean[$key] = $value;
            }
        }

        return $clean;
    }
}
