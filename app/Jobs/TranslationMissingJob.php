<?php

namespace App\Jobs;

use Alessiodh\Deepltranslator\Traits\DeepltranslatorTrait;
use App\Models\SystemTranslation;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;

class TranslateMissingTranslationJob implements ShouldQueue, ShouldBeUnique
{
    use DeepltranslatorTrait;

    public string $key;

    /**
     * Gets the Translation Key
     * @return string
     */
    public function uniqueId(): string
    {
        return $this->key;
    }

    /**
     * Create a new job instance.
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }


    /**
     * Translates a missing Translation using DeepL
     * Execute the job.
     */
    public function handle(): void
    {
        if (!empty($this->key)) {
            // Search BINARY so its case sensitive
            $systemTranslation = SystemTranslation::whereRaw('BINARY ' . SystemTranslation::TRANSLATION_KEY . ' = ?', [
                $this->key
            ])->where(SystemTranslation::TRANSLATION_GROUP, '=', '*')->first();

            if (empty($systemTranslation)) {
                // Create a new SystemTranslation if it does not exist.
                $systemTranslation                      = new SystemTranslation;
                $systemTranslation->translation_key     = $this->key;
                $systemTranslation->translation_group   = '*';
            }

            $locales = ['nl', 'en'];

            // Translate using DeepL
            $translated = $this->translateString($this->key, 'nl', $locales);

            // Update the SystemTranslation
            $systemTranslation->fill([
                SystemTranslation::TRANSLATION_TEXT => $translated,
            ])->save();
        }
    }
}
