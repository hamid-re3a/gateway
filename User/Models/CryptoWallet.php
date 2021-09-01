<?php

namespace User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class CryptoWallet extends Model
{
    use SoftDeletes;

    protected $guard_name = 'api';
    protected $table = 'crypto_wallets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'crypto_currency_id',
        'address',
        'description',
        'is_active'
    ];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'user_id' => 'integer',
        'crypto_currency_id' => 'integer',
        'address' => 'string',
        'is_active' => 'boolean'
    ];

    /**
     * relations
     */

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function cryptoCurrency()
    {
        return $this->belongsTo(CryptoCurrency::class,'crypto_currency_id','id');
    }

    public function cryptoWalletHistories()
    {
        return $this->hasMany(CryptoWalletHistory::class,'wallet_id','id');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active',1);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active',0);
    }

    /**
     * Mutators
     */
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = $value;
        if(empty($this->attributes['uuid'])) {
            $uuid = Uuid::uuid4()->toString();
            while($this->where('uuid', $uuid)->first())
                $uuid = Uuid::uuid4()->toString();

            $this->attributes['uuid'] = $uuid;
        }
    }


}
