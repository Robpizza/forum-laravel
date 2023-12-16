<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Spatie\TranslationLoader\LanguageLine;

/**
 * Class SystemTranslation
 *
 * @property int $translation_id
 * @property string $translation_group
 * @property string $translation_key
 * @property string $translation_text
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App\Models\Base
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
class SystemTranslation extends LanguageLine
{
	const TRANSLATION_ID = 'translation_id';
	const TRANSLATION_GROUP = 'translation_group';
	const TRANSLATION_KEY = 'translation_key';
	const TRANSLATION_TEXT = 'translation_text';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	protected $table = 'system_translations';
	protected $primaryKey = 'translation_id';
	protected $perPage = 50;
	public $timestamps = false;

	protected $casts = [
		self::TRANSLATION_ID => 'int',
        self::TRANSLATION_TEXT => 'array',
		self::CREATED_AT => 'datetime',
		self::UPDATED_AT => 'datetime'
	];
}
