<?php

namespace R2FUser\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * R2FUser\Models\UserActivity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $ip_id
 * @property int|null $agent_id
 * @property string|null $route
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereIpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereUserId($value)
 * @mixin \Eloquent
 */
class UserActivity extends Model
{
    use HasFactory;
    protected $guarded = [];
}
