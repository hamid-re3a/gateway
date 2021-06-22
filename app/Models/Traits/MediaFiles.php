<?php


namespace App\Models\Traits;


use App\Models\Media;

trait MediaFiles
{
    public function mediaImage()
{
    return $this->morphOne(Media::class, 'model')
        ->whereIn('type', IMAGE_MIME_TYPES);

}
    public function mediaVideo()
    {
        return $this->morphOne(Media::class, 'model')
            ->whereIn('type', VIDEO_MIME_TYPES);

    }

    public function mediaPDF()
    {
        return $this->morphOne(Media::class, 'model')
            ->whereIn('type', PDF_MIME_TYPES);
    }

    public function mediaAudio()
    {
        return $this->morphOne(Media::class, 'model')
            ->whereIn('type', AUDIO_MIME_TYPES);
    }



    public function mediaImages()
    {
        return $this->morphMany(Media::class, 'model')
            ->whereIn('type', IMAGE_MIME_TYPES);

    }
    public function mediaVideos()
    {
        return $this->morphMany(Media::class, 'model')
            ->whereIn('type', VIDEO_MIME_TYPES);

    }

    public function mediaPDFs()
    {
        return $this->morphMany(Media::class, 'model')
            ->whereIn('type', PDF_MIME_TYPES);
    }

    public function mediaAudios()
    {
        return $this->morphMany(Media::class, 'model')
            ->whereIn('type', AUDIO_MIME_TYPES);
    }
}
