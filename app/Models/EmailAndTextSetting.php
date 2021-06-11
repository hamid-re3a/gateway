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
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereFromName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereVariablesDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailAndTextSetting whereVariablesNumber($value)
 * @mixin \Eloquent
 */
class EmailAndTextSetting extends Model
{
    use HasFactory;
    protected $guarded = [];
}
