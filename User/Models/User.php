<?php

namespace User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use MLM\Services\Grpc\MLMServiceClient;
use User\database\factories\UserFactory;
use User\Exceptions\InvalidFieldException;
use Spatie\Permission\Traits\HasRoles;
use User\Observers\UserObserver;
use MLM\Services\MlmClientFacade;

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
 * @property int $member_id
 * @property int $sponsor_id
 * @property boolean $is_deactivate
 * @property boolean $is_freeze
 * @property string $first_name
 * @property string $last_name
 * @property string|null $username
 * @property string|null $phone_number
 * @property string|null $mobile_number
 * @property string|null $landline_number
 * @property string $email
 * @property string $password
 * @property string $address_line1
 * @property string $address_line2
 * @property string $gender
 * @property string|null $transaction_password
 * @property string|null $rank_name
 * @property string|null $avatar
 * @property string|null $passport_number
 * @property int|null $is_passport_number_accepted
 * @property string|null $national_id
 * @property int|null $is_national_id_accepted
 * @property int|null $state_id
 * @property int|null $city_id
 * @property int|null $country_id
 * @property int|null $zip_code
 * @property string|null $driving_licence
 * @property int|null $is_driving_licence_accepted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User filter()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDrivingLicence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMemberId($value)
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
 * @property-read \Illuminate\Database\Eloquent\Collection|Country[] $country
 * @property-read \Illuminate\Database\Eloquent\Collection|City[] $city
 * @property-read \Illuminate\Database\Eloquent\Collection|City[] $state
 * @property-read User $sponsor
 */
class User extends Authenticatable
{

    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasApiTokens;


    use HasRoles {
        assignRole as protected originalAssignRole;
    }

    /**
     * @param mixed ...$roles
     * @return $this
     */
    public function assignRole(...$roles)
    {
        $this->originalAssignRole(...$roles);


        return $this;
    }

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
        'member_id',
        'first_name',
        'last_name',
        'username',
        'mobile_number',
        'landline_number',
        'address_line1',
        'address_line2',
        'email',
        'gender',
        'birthday',
        'rank_name',
        'password',
        'transaction_password',
        'country_id',
        'city_id',
        'state_id',
        'block_type',
        'block_reason',
        'avatar',
        'passport_number',
        'email_verified_at',
        'google2fa_enable',
        'google2fa_secret',
        'is_freeze',
        'is_deactivate',
        'zip_code',
        'sponsor_id'
    ];

    protected $casts = [
        'birthday' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_freeze' => 'boolean',
        'is_deactivate' => 'boolean',
    ];

    /**
     * Scopes
     */

    public function scopeFilter($query)
    {
        if(request()->has('username'))
            $query->where('username','LIKE','%' . request()->get('username') . '%');

        if(request()->has('rank'))
            $query->where('rank_name','LIKE', '%' . request()->get('rank') . '%');

        if(request()->has('ranks') AND is_array(request()->get('ranks')))
            foreach(request()->get('ranks') AS $rank)
                $query->where('rank_name','LIKE', '%' . $rank . '%');

        if(request()->has('email'))
            $query->where('email','LIKE','%'. request()->get('email') .'%');

        if(request()->has('membership_id'))
            $query->where('membership_id','LIKE','%' . request()->get('membership_id') . '%');

        return $query;

    }

    public function updateUserRank()
    {
        $user_rank_grpc = MlmClientFacade::getUserRank($this->getGrpcMessage());
        $this->update([
            'rank_name' => $user_rank_grpc->getRankName()
        ]);
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

//    public function agents()
//    {
//        return $this->hasMany(Agent::class,'user_id','id');
//    }

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

    public function wallets()
    {
        return $this->hasMany(CryptoWallet::class,'user_id','id');
    }

    public function activities()
    {
        return $this->hasMany(UserActivity::class,'user_id','id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(City::class,'state_id','id')->whereNull('parent_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_id','id')->whereNotNull('parent_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class,'sponsor_id','id');
    }

    /**
     * methods
     */
    public function isEmailVerified()
    {
        return  ! is_null($this->email_verified_at);
    }

    public function isDeactivate()
    {
        return $this->is_deactivate;
    }

    public function signOut()
    {
//        $this->agents()->update([
//            'token_id' => null
//        ]);
        $this->tokens()->delete();
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


    /**
     * Methods
     */
    public function getGrpcMessage()
    {
        $this->fresh();
        $user = new \User\Services\Grpc\User();
        $user->setId((int)$this->attributes['id']);
        $user->setFirstName((string)$this->attributes['first_name']);
        $user->setLastName((string)$this->attributes['last_name']);
        $user->setUsername((string)$this->attributes['username']);
        $user->setEmail((string)$this->attributes['email']);
        $user->setMemberId((int)$this->attributes['member_id']);
        $user->setSponsorId((int)$this->attributes['sponsor_id']);
        $user->setBlockType((string)$this->attributes['block_type']);
        $user->setIsDeactivate((boolean)$this->attributes['is_deactivate']);
        $user->setIsFreeze((boolean)$this->attributes['is_freeze']);
        $user->setGender((string)$this->attributes['gender']);

        if ($this->getRoleNames()->count()) {
            $role_name = implode(",", $this->getRoleNames()->toArray());
            $user->setRole($role_name);
        }

        return $user;
    }


    /**
     * Mutators
     */
    public function setLandlineNumberAttribute($value)
    {
        if(!empty($value)){
            $this->attributes['landline_number'] = phone($value,$this->country->iso2)->formatInternational();
        }

    }

    public function setMobileNumberAttribute($value)
    {
        if(!empty($value)){
            $this->attributes['mobile_number'] = phone($value,$this->country->iso2)->formatInternational();
        }

    }

    public function setPasswordAttribute($value)
    {
        if(empty($this->attributes['member_id'])) {
            //User member_id field
            $member_id = mt_rand(121212121,999999999);
            while ($this->where('member_id', $member_id)->count())
                $member_id = mt_rand(121212121,999999999);

            $this->attributes['member_id'] = $member_id;
        }

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



}
