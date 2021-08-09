<?php

namespace User\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoCurrency extends Model
{

    protected $guard_name = 'api';
    protected $table = 'crypto_currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'contract',
        'is_active',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'contract' => 'string',
        'is_active' => 'boolean'
    ];

    /**
     * relations
     */

    public function wallets()
    {
        return $this->hasMany(CryptoWallet::class,'crypto_currency_id','id');
    }

    /*
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active',true);
    }

}
