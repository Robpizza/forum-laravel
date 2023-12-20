<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemTranslation
 *
 * @property int $translation_id
 * @property string $translation_group
 * @property string $translation_key
 * @property string $translation_text
 * @property int|null $translation_checked
 * @property Carbon|null $translation_createdate
 * @property int $translation_createuser
 * @property Carbon|null $translation_changedate
 * @property int $translation_changeuser
 * @package App\Models\Base
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationChangedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationChangeuser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationCreatedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationCreateuser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTranslation whereTranslationText($value)
 * @mixin \Eloquent
 */
class SystemTranslation extends Model
{
    const TRANSLATION_ID = 'translation_id';
    const TRANSLATION_GROUP = 'translation_group';
    const TRANSLATION_KEY = 'translation_key';
    const TRANSLATION_TEXT = 'translation_text';
    const TRANSLATION_CHECKED = 'translation_checked';
    const TRANSLATION_CREATEDATE = 'translation_createdate';
    const TRANSLATION_CREATEUSER = 'translation_createuser';
    const TRANSLATION_CHANGEDATE = 'translation_changedate';
    const TRANSLATION_CHANGEUSER = 'translation_changeuser';
    protected $table = 'system_translations';
    protected $primaryKey = 'translation_id';
    protected $perPage = 50;
    public $timestamps = false;

    protected $casts = [
        self::TRANSLATION_ID => 'int',
    ];

    protected array $dates = [
        self::TRANSLATION_CREATEDATE,
        self::TRANSLATION_CHANGEDATE
    ];
}