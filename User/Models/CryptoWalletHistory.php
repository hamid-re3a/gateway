<?php

namespace User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CryptoWalletHistory extends Model
{
    use SoftDeletes;

    protected $guard_name = 'api';
    protected $table = 'crypto_wallet_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'actor_id',
        'wallet_id',
        'uuid',
        'user_id',
        'crypto_currency_id',
        'address',
        'description',
        'is_active'
    ];

    protected $casts = [
        'id' => 'integer',
        'actor_id' => 'integer',
        'wallet_id' => 'integer',
        'uuid' => 'string',
        'user_id' => 'integer',
        'crypto_currency_id' => 'integer',
        'address' => 'string',
        'is_active' => 'boolean'
    ];

    /**
     * relations
     */

    public function actor()
    {
        return $this->belongsTo(User::class,'actor_id','id');
    }

    public function wallet()
    {
        return $this->belongsTo(CryptoWallet::class,'wallet_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function cryptoCurrency()
    {
        return $this->belongsTo(CryptoCurrency::class,'crypto_currency_id','id');
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

}
