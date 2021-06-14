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
 */
class LoginAttempt extends Model
{
    use HasFactory;
}
