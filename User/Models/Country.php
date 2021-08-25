<?php

namespace User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * User\Models\ForgetPassword
 *
 * @property int $id
 * @property string $iso2
 * @property string $name_official
 * @property string $name_common
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Otp type($type)
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Otp whereDeletedAt($value)
 */
class Country extends Model
{
    use SoftDeletes;
    protected $table = 'countries';

    protected $fillable = [
        'iso2',
        'name',
    ];

    public function states()
    {
        return $this->hasMany(City::class,'country_id','id')->whereNull('parent_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class,'country_id','id')->whereNotNull('parent_id');
    }

}
