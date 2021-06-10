<?php

namespace App\Models;

use App\Models\Traits\MediaFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\KYC
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Media|null $mediaAudio
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $mediaAudios
 * @property-read int|null $media_audios_count
 * @property-read \App\Models\Media|null $mediaImage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $mediaImages
 * @property-read int|null $media_images_count
 * @property-read \App\Models\Media|null $mediaPDF
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $mediaPDFs
 * @property-read int|null $media_p_d_fs_count
 * @property-read \App\Models\Media|null $mediaVideo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $mediaVideos
 * @property-read int|null $media_videos_count
 * @method static \Illuminate\Database\Eloquent\Builder|KYC newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KYC newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KYC query()
 * @method static \Illuminate\Database\Eloquent\Builder|KYC whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KYC whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KYC whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KYC whereUserId($value)
 * @mixin \Eloquent
 */
class KYC extends Model
{
    use HasFactory;
    use MediaFiles;

    protected $guarded =[];
}
