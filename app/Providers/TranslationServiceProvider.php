<?php

namespace App\Providers;

use App\Helpers\Translator;

class TranslationServiceProvider extends \Spatie\TranslationLoader\TranslationServiceProvider {

    public function register(): void
    {
        parent::registerLoader();
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            $locale = config('app.locale');
            $trans = new Translator($loader, $locale);
            $trans->setFallback(config('fallback_locale'));
            return $trans;
        });
    }
}