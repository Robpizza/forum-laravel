<?php

namespace App\Models;

use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

/**
 * App\Models\SystemTranslation
 *
 * @property int $translation_id
 * @property string $translation_group
 * @property string $translation_key
 * @property array $translation_text
 * @property \Illuminate\Support\Carbon|null $translation_createdate
 * @property \Illuminate\Support\Carbon|null $translation_changedate
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationChangedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationCreatedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationText($value)
 * @mixin \Eloquent
 */
class SystemTranslation extends LanguageLine
{
    const TRANSLATION_ID = 'translation_id';
    const TRANSLATION_GROUP = 'translation_group';
    const TRANSLATION_KEY = 'translation_key';
    const TRANSLATION_TEXT = 'translation_text';
    const TRANSLATION_CREATEDATE = 'translation_createdate';
    const TRANSLATION_CHANGEDATE = 'translation_changedate';
    protected $table = 'system_translations';
    protected $primaryKey = 'translation_id';
    protected $perPage = 50;
    public $timestamps = true;

    protected $casts = [
        self::TRANSLATION_ID => 'int',
        self::TRANSLATION_TEXT => 'array',
    ];

    protected $dates = [
        self::TRANSLATION_CREATEDATE,
        self::TRANSLATION_CHANGEDATE,
    ];

    protected $fillable = [
        self::TRANSLATION_GROUP,
        self::TRANSLATION_KEY,
        self::TRANSLATION_TEXT,
        self::TRANSLATION_CREATEDATE,
        self::TRANSLATION_CHANGEDATE,
    ];

    public $translatable = [
        self::TRANSLATION_TEXT,
    ];

    public $guarded = [
        self::TRANSLATION_ID,
    ];

    const CREATED_AT = self::TRANSLATION_CREATEDATE;
    const UPDATED_AT = self::TRANSLATION_CHANGEDATE;


    public static function getTranslationsForGroup(string $locale, string $group): array
    {
        return Cache::rememberForever(static::getCacheKey($group, $locale), function () use ($group, $locale) {
            return static::query()
                ->where(self::TRANSLATION_GROUP, $group)
                ->get()
                ->reduce(function ($lines, self $systemTranslation) use ($group, $locale) {
                    $translation = $systemTranslation->getTranslation($locale);

                    if ($translation !== null && $group === '*') {
                        // Make a flat array when returning json translations
                        $lines[$systemTranslation->translation_key] = $translation;
                    } elseif ($translation !== null && $group !== '*') {
                        // Make a nested array when returning normal translations
                        Arr::set($lines, $systemTranslation->translation_key, $translation);
                    }

                    return $lines;
                }) ?? [];
        });
    }

    public function getTranslation(string $locale): ?string
    {
        if (!isset($this->translation_text[$locale])) {
            $fallback = config('app.fallback_locale');

            return $this->translation_text[$fallback] ?? null;
        }

        return $this->translation_text[$locale];
    }

    public function setTranslation(string $locale, string $value): SystemTranslation|static
    {
        $this->translation_text = array_merge($this->translation_text ?? [], [$locale => $value]);

        return $this;
    }

    public function flushGroupCache(): void
    {
        foreach ($this->getTranslatedLocales() as $locale) {
            Cache::forget(static::getCacheKey($this->translation_group, $locale));
        }
    }

    protected function getTranslatedLocales(): array
    {
        return array_keys($this->translation_text);
    }
}
