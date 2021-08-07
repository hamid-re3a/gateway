<?php

namespace User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use User\database\factories\UserFactory;
use User\Exceptions\InvalidFieldException;
use User\Exceptions\OldPasswordException;
use Spatie\Permission\Traits\HasRoles;

/**
 * User\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @mixin \Eloquent
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $username
 * @property string|null $phone_number
 * @property string $email
 * @property string $password
 * @property string|null $transaction_password
 * @property string|null $avatar
 * @property string|null $passport_number
 * @property int|null $is_passport_number_accepted
 * @property string|null $national_id
 * @property int|null $is_national_id_accepted
 * @property string|null $driving_licence
 * @property int|null $is_driving_licence_accepted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDrivingLicence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsDrivingLicenceAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsNationalIdAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsPassportNumberAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTransactionPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @property string|null $otp
 * @property string|null $otp_datetime
 * @property int|null $otp_tries
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOtpDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOtpTries($value)
 * @property int $google2fa_enable
 * @property string|null $google2fa_secret
 * @property-read mixed $full_name
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGoogle2faEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGoogle2faSecret($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\User\Models\LoginAttempt[] $loginAttempts
 * @property-read int|null $login_attempts_count
 * @property int $is_email_verified
 * @property string|null $email_verified_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\User\Models\Otp[] $otps
 * @property-read int|null $otps_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsEmailVerified($value)
 * @property string|null $block_type
 * @property string|null $block_reason
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBlockReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBlockType($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|UserBlockHistory[] $blockHistories
 * @property-read int|null $block_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|PasswordHistory[] $passwordHistories
 * @property-read int|null $password_histories_count
 */
class User extends Authenticatable
{

    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasApiTokens;

    protected $guard_name = 'api';

    protected static function newFactory()
    {
        return UserFactory::new();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'phone_number',
        'email',
        'password',
        'transaction_password',
        'block_type',
        'block_reason',
        'avatar',
        'passport_number',
        'email_verified_at',
        'google2fa_enable',
        'google2fa_secret'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setTransactionPasswordAttribute($value)
    {
        $this->attributes['transaction_password'] = bcrypt($value);
    }

    public function getFullNameAttribute()
    {
        return ucwords(strtolower($this->first_name . ' ' . $this->last_name));
    }

    /**
     * relations
     */
    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempt::class);
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class,'user_id','id');
    }

    public function ips()
    {
        return $this->hasMany(Ip::class,'user_id','id');
    }

    public function userHistories($field = null)
    {
        if(!is_null($field) AND in_array($field, $this->getFillable()))
            return $this->hasMany(UserHistory::class,'user_id','id')->distinct($field)->whereNotNull($field);

        return $this->hasMany(UserHistory::class,'user_id','id');
    }

    /**
     * methods
     */
    public function isEmailVerified()
    {
        return  ! is_null($this->email_verified_at);
    }

    public function historyCheck($field,$value)
    {
        //Check columns
        if(!in_array($field,$this->getFillable()))
            return new InvalidFieldException();
        $history = $this->userHistories()->distinct($field)->pluck($field);
        foreach ($history as $item)
            if(Hash::check($value, $item))
                return true;

        return false;
    }

}
