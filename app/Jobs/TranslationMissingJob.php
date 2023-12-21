<?php

namespace App\Jobs;

use Alessiodh\Deepltranslator\Traits\DeepltranslatorTrait;
use App\Models\SystemTranslation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TranslationMissingJob implements ShouldQueue, ShouldBeUnique
{
    use DeepltranslatorTrait, Queueable, InteractsWithQueue;

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [60, 60, 300];
    }

    /**
     * Gets the Translation Key
     * @return string
     */
    public function uniqueId(): string
    {
        return $this->key;
    }

    public string $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function handle(): bool
    {
        if (!empty($this->key)) {
            $languageLine = SystemTranslation::whereRaw('BINARY ' . SystemTranslation::TRANSLATION_KEY . ' = ?', [
                $this->key,
            ])->where(SystemTranslation::TRANSLATION_GROUP, '*')->first();
            if (empty($languageLine)) {
                $languageLine = new SystemTranslation;
                $languageLine->translation_key = $this->key;
                $languageLine->translation_group = '*';
            }

            $locales = [];
            foreach (config('app.locales') as $tmpLocale) {
                if ($tmpLocale === 'nl') continue;
                $locales[] = $tmpLocale;
            }

            // Translate using DeepL
            $translated = $this->translateString($this->key, 'nl', $locales);
            $languageLine->fill([
                SystemTranslation::TRANSLATION_TEXT => $translated,
            ])->save();
        }
        return true;
    }
}
