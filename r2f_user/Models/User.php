<?php

namespace R2FUser\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * R2FUser\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ticket[] $tickets
 * @property-read int|null $tickets_count
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\KYC[] $kycs
 * @property-read int|null $kycs_count
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
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasApiTokens;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function getFullNameAttribute()
    {
        return ucwords(strtolower($this->first_name . ' ' . $this->last_name));
    }

    /**
     * relations
     */
    public function kycs()
    {
        return $this->hasMany(KYC::class);
    }
    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempt::class);
    }


    /**
     * methods
     */


    /**
     * @throws \Exception
     */
    public function makeForgetPasswordOtp(): array
    {
        $token = null;
        $error = null;
        if (is_null($this->otp_datetime))
            $this->otp_datetime = Carbon::now();

        $diff_last_try_in_minutes = Carbon::now()->diffInMonths(Carbon::make($this->otp_datetime));
        if ($diff_last_try_in_minutes > getSetting("USER_OTP_DURATION")) {
            $this->otp_tries = 1;
        }

        $this->otp_datetime = Carbon::now();
        $this->otp_tries += 1;


        if ($this->otp_tries >= getSetting("USER_OTP_MAX_TRIES")) {
            $error = trans('responses.max-otp-exceed');
        } else {
            $token = Str::random(4);
            $this->otp = $token;
        }
        $this->save();

        return [$token, $error];


    }
}
