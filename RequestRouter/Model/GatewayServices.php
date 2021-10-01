<?php

namespace RequestRouter\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GatewayServices
 * @package RequestRouter\Models
 */

/**
 * RequestRouter\Model\GatewayServices
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices query()
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices whereValue($value)
 * @mixin \Eloquent
 * @property string|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|GatewayServices whereCategory($value)
 */
class GatewayServices extends Model
{
    use HasFactory;
    protected $table = "gateway_services";
    protected $fillable = [
        'name',
        'doc_point',
        'just_current_routes',
        'domain'
    ];
}
