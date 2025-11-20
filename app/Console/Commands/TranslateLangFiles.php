<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OpenAITranslator;
use Illuminate\Support\Facades\File;

class TranslateLangFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:translate {code} {--from=en}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate prepared lang files using OpenAI';

    /**
     * Execute the console command.
     */
    public function handle(OpenAITranslator $translator)
    {
        $from = strtolower($this->option('from'));
        $to = strtolower($this->argument('code'));

        $base = base_path("lang/{$from}");
        $target = base_path("lang/{$to}");

        if (!File::exists($base)) {
            $this->error("Source folder /lang/{$from} does not exist.");
            return Command::FAILURE;
        }

        if (!File::exists($target)) {
            $this->error("Target folder /lang/{$to} does not exist. Run: php artisan lang:prepare {$to}");
            return Command::FAILURE;
        }

        foreach (File::allFiles($base) as $file) {
            $this->info("Translating: {$file->getFilename()}");

            $sourceArray = include $file->getPathname();
            if (!is_array($sourceArray)) continue;

            $translated = $this->translateArray($sourceArray, $from, $to, $translator);

            $output = "<?php\n\nreturn " . $this->arrayToPhp($translated) . ";\n";

            File::put("{$target}/{$file->getFilename()}", $output);

            $this->info("Saved: lang/{$to}/{$file->getFilename()}");
        }

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

    private function translateArray(array $array, string $from, string $to, OpenAITranslator $translator): array
    {
        $result = [];

        foreach ($array as $key => $value) {

            if (is_array($value)) {
                $result[$key] = $this->translateArray($value, $from, $to, $translator);
                continue;
            }

            if (is_string($value)) {
                $this->line("   → $key");

                $result[$key] = $translator->translate(
                    text: $value,
                    from: $from,
                    to:   $to,
                    prompt: "
                        You are a translation engine. Translate strictly from {$from} to {$to} (language code).

                        RULES:
                        - Translate ONLY into the target language '{$to}'. Do not use any other language.
                        - Return ONLY the translated text (no comments, quotes, brackets, or explanations).
                        - If text is empty, return empty string.
                        - If translation is unclear, keep the original text instead of guessing.

                        PLACEHOLDERS:
                        - NEVER change placeholders like:
                            :attribute :value :min :max :count :values
                        - They must appear in the output EXACTLY as in the input.

                        HTML ENTITIES (VERY IMPORTANT):
                        - NEVER decode HTML entities into characters.
                        - NEVER change or remove them.
                        - KEEP THEM EXACTLY AS TEXT:
                            &laquo; &raquo; &amp; &quot; &lt; &gt; &#187; &#171;

                        FORMATTING:
                        - Preserve punctuation.
                        - Do not add or remove any symbols.

                        Output ONLY the translated string.
                    "
                );
                sleep(1);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
