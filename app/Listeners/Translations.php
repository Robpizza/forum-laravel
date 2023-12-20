<?php

namespace App\Listeners;

use App\Events\TranslationMissing;
use App\Jobs\TranslationMissingJob;

class Translations
{

    public function onTranslationMissing(TranslationMissing $event): bool
    {
        $job = new TranslationMissingJob($event->key);
        dispatch($job);

        return true;
    }

    public function subscribe($events): void
    {
        $events->listen(
            'App\Events\TranslationMissing',
            'App\Listeners\Translations@onTranslationMissing'
        );
    }
}