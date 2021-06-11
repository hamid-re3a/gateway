<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserAgent
 *
 * @property int $id
 * @property string|null $ip
 * @property string|null $iso_code
 * @property string|null $country
 * @property string|null $city
 * @property string|null $state
 * @property string|null $state_name
 * @property string|null $postal_code
 * @property string|null $lat
 * @property string|null $lon
 * @property string|null $timezone
 * @property string|null $continent
 * @property string|null $currency
 * @property string|null $default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereContinent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereStateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAgent whereUserId($value)
 */
class UserAgent extends Model
{
    use HasFactory;
    protected $guarded = [];
}
