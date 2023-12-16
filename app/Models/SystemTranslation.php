<?php

namespace App\Models;

use App\Models\Base\SystemTranslation as BaseSystemTranslation;
use Illuminate\Support\Arr;

/**
 * App\Models\SystemTranslation
 *
 * @property int $translation_id
 * @property string $translation_group
 * @property string $translation_key
 * @property string $translation_text
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemTranslation extends BaseSystemTranslation
{
    protected $fillable = [
        self::TRANSLATION_GROUP,
        self::TRANSLATION_KEY,
        self::TRANSLATION_TEXT,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    public $timestamps = true;

    public $translatable = [
        self::TRANSLATION_TEXT,
    ];

    public $guarded = [
        self::TRANSLATION_ID
    ];

    public static function getTranslationsForGroup(string $locale, string $group): array
    {
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
    }

    public function getTranslation(string $locale): ?string
    {
        dd($locale);
        if (!isset($this->translation_text[$locale])) {
            $fallback = config('app.fallback_locale');

            return $this->translation_text[$fallback] ?? null;
        }

        return $this->translation_text[$locale];
    }

    public function setTranslation(string $locale, string $value)
    {
        $this->translation_text = array_merge($this->translation_text ?? [], [$locale => $value]);

        return $this;
    }

    protected function getTranslatedLocales(): array
    {
        return array_keys( json_decode($this->translation_text, true) );
    }
}
