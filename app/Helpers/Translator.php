<?php

namespace App\Helpers;

use App\Events\TranslationMissing;

class Translator extends \Illuminate\Translation\Translator
{
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $translation = parent::get($key, $replace, $locale, false);

        if (!empty($key) && $translation === $key) {
            $locale = $locale ?: $this->locale;
            $line = $this->loaded['*']['*'][$locale][$key] ?? null;
            if (!isset($line) && $locale !== 'nl') {
                [$namespace, $group, $item] = parent::parseKey($key);
                if (!in_array($group, [
                    'auth',
                    'pagination',
                    'passwords',
                    'validation',
                ])) {
                    // Dispatch event to translate in the background
                    event(new TranslationMissing($key));
                }
            }
        }

        return $translation;
    }
}