<?php

namespace R2FUser\Models;

use App\Http\Helpers\ResponseData;
use Illuminate\Support\Facades\Hash;
use R2FUser\Models\PasswordHistory;
use R2FUser\Models\UserBlockHistory;
use Illuminate\Http\Request;
use R2FUser\Jobs\EmailJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use R2FUser\Mail\User\EmailVerifyOtp;
use R2FUser\Mail\User\ForgetPasswordOtpEmail;
use R2FUser\Mail\User\WelcomeEmail;
use R2FUser\Support\UserActivityHelper;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\R2FUser\Models\LoginAttempt[] $loginAttempts
 * @property-read int|null $login_attempts_count
 * @property int $is_email_verified
 * @property string|null $email_verified_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\R2FUser\Models\Otp[] $otps
 * @property-read int|null $otps_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsEmailVerified($value)
 * @property string|null $block_type
 * @property string|null $block_reason
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBlockReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBlockType($value)
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

        if (getSetting("USER_CHECK_PASSWORD_HISTORY_FOR_NEW_PASSWORD") ){
            if(Hash::check($value,$this->attributes['password']))
                abort(400,trans('responses.password-already-used-by-you-try-another-one'));

            $passwords = $this->passwordHistories()->get();
            foreach($passwords as $item)
                if(Hash::check($value,$item->password))
                    abort(400,trans('responses.password-already-used-by-you-try-another-one'));

        }

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

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }


    public function blockHistories()
    {
        return $this->hasMany(UserBlockHistory::class);
    }

    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    /**
     * methods
     */

    public function isEmailVerified(): bool
    {
        return (bool)($this->is_email_verified == true);
    }

    /**
     * @throws \Exception
     */
    public function makeForgetPasswordOtp(Request $request): array
    {
        $token = null;
        $error = null;

        $intervals = explode(',', getSetting('USER_FORGOT_PASSWORD_OTP_INTERVALS'));
        $reverse_intervals = array_reverse($intervals);
        $tries = getSetting('USER_FORGOT_PASSWORD_OTP_TRIES');

        foreach ($reverse_intervals as $key => $interval) {

            $sum_up_key = (count($intervals) - 1 - $key);
            if (Otp::query()
                    ->type(OTP_EMAIL_FORGOT_PASSWORD)
                    ->whereBetween('created_at', [now()->subSeconds(sumUp($intervals, $sum_up_key) + $interval)->format('Y-m-d H:i:s'), now()->subSeconds(sumUp($intervals, $key))->format('Y-m-d H:i:s')])
                    ->count() <= $tries * ($sum_up_key + 1)) {
                $token = $this->getRandomOtp();

                list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
                Otp::query()->create([
                    "user_id" => $this->id,
                    "ip_id" => is_null($ip_db) ? null : $ip_db->id,
                    "agent_id" => is_null($agent_db) ? null : $agent_db->id,
                    "otp" => $token,
                    "type" => OTP_EMAIL_FORGOT_PASSWORD
                ]);
                EmailJob::dispatch(new ForgetPasswordOtpEmail($this, $token), $this->email)->onQueue(QUEUES_EMAIL);
                return [$token, $error];

            }
        }
        $error = true;
        return [$token, $error];


    }

    /**
     * @param bool $is_welcome
     * @return array
     * @throws \Exception
     */
    public function makeEmailVerificationOtp(Request $request, $is_welcome = true): array
    {
        $token = null;
        $error = null;

        $intervals = explode(',', getSetting('USER_EMAIL_VERIFICATION_OTP_INTERVALS'));
        $reverse_intervals = array_reverse($intervals);
        $tries = getSetting('USER_EMAIL_VERIFICATION_OTP_TRIES');

        foreach ($reverse_intervals as $key => $interval) {

            $sum_up_key = (count($intervals) - 1 - $key);
            if (Otp::query()
                    ->type(OTP_EMAIL_VERIFICATION)
                    ->whereBetween('created_at', [now()->subSeconds(sumUp($intervals, $sum_up_key) + $interval)->format('Y-m-d H:i:s'), now()->subSeconds(sumUp($intervals, $key))->format('Y-m-d H:i:s')])
                    ->count() <= $tries * ($sum_up_key + 1)) {
                $token = $this->getRandomOtp();

                list($ip_db, $agent_db) = UserActivityHelper::getInfo($request);
                Otp::query()->create([
                    "user_id" => $this->id,
                    "ip_id" => is_null($ip_db) ? null : $ip_db->id,
                    "agent_id" => is_null($agent_db) ? null : $agent_db->id,
                    "otp" => $token,
                    "type" => OTP_EMAIL_VERIFICATION
                ]);

                if ($is_welcome)
                    EmailJob::dispatch(new WelcomeEmail($this, $token), $this->email)->onQueue(QUEUES_EMAIL);
                else
                    EmailJob::dispatch(new EmailVerifyOtp($this, $token), $this->email)->onQueue(QUEUES_EMAIL);
                return [$token, $error];

            }
        }
        $error = true;
        return [$token, $error];


    }

    /**
     * @return int
     * @throws \Exception
     */
    private function getRandomOtp(): int
    {
        return random_int(pow(10, 5), pow(10, 6) - 1);
    }

}
