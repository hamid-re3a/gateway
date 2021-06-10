<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Media
 *
 * @property int $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string $name
 * @property string|null $url
 * @property string|null $type
 * @property string $file_name
 * @property int $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $model
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUrl($value)
 * @mixin \Eloquent
 */
class Media extends Model
{
    protected $table = "media";
    protected $guarded = [];

    public function model()
    {
        return $this->morphTo();
    }
}
