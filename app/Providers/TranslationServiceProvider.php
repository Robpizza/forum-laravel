<?php

namespace App\Providers;

use App\Helpers\Translator;
use Spatie\TranslationLoader\TranslationServiceProvider;

class TranslateServiceProvider extends TranslationServiceProvider
{
    public function register()
    {
        parent::registerLoader();

        $this->app->singleton('translator', function($app) {
            $loader = $app['translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = config('app.locale');

            $trans = new Translator($loader, $locale);
            $trans->setFallback(config('fallback_locale'));

            return $trans;
        });
    }
}