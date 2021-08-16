<?php

namespace User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GatewayServicesSeeder
 * @package User\Models
 */
class GatewayServices extends Model
{
    use HasFactory;
    protected $table = "gateway_services";
    protected $fillable = [
        'name',
        'doc_point',
        'just_current_routes',
        'domain'
    ];
}
