<?php

namespace App\Listeners;

use App\Events\TranslationMissing;
use App\Jobs\TranslateMissingTranslationJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Translations
{
    public function onTranslationMissing(TranslationMissing $event): bool
    {
        $job = new TranslateMissingTranslationJob($event->key);
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
