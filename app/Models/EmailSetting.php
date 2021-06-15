<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmailAndTextSetting
 *
 * @property int $id
 * @property string $key
 * @property string $subject
 * @property string $from
 * @property string $from_name
 * @property string $body
 * @property int $variables_number
 * @property string $variables_description
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereFromName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereVariablesDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereVariablesNumber($value)
 * @mixin \Eloquent
 * @property string $variables
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereVariables($value)
 */
class EmailSetting extends Model
{
    use HasFactory;
    protected $guarded = [];
}
