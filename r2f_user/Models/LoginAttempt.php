<?php

namespace R2FUser\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * R2FUser\Models\LoginAttempt
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereUserId($value)
 * @property int|null $agent_id
 * @property int $is_success
 * @property int $is_from_new_device
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereIsFromNewDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereIsSuccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereUserAgentId($value)
 * @property int|null $ip_id
 * @property-read \R2FUser\Models\Agent|null $agent
 * @property-read string $login_status
 * @property-read \R2FUser\Models\Ip|null $ip
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginAttempt whereIpId($value)
 */
class LoginAttempt extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function getLoginStatusAttribute(): string
    {
        switch ($this->is_success) {
            case 2:
                $status = 'failed';
                break;
            case 1:
                $status = 'succeed';
                break;
            case 3:
                $status = 'blocked';
                break;
            case 0:
            default:
                $status = 'on going';
        }
        return $status;
    }

    /**
     * relations
     */

    public function ip()
    {
        return $this->belongsTo(Ip::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
