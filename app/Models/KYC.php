<?php

namespace App\Models;

use App\Models\Traits\MediaFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KYC extends Model
{
    use HasFactory;
    use MediaFiles;
}
