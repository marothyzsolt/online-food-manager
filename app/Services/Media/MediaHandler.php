<?php

namespace App\Services\Media;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Storage;

class MediaHandler
{
    private string $disk = 'images';

    public function storeUploadedMedia(UploadedFile $uploadedFile): Media
    {
        if (! ($media = $this->hashExists(md5($uploadedFile->get())))) {
            $media = $this->makeMedia(uniqid(), $uploadedFile->getMimeType());
        }

        return $media;
    }

    public function makeMedia(string $path, string $mimeType): Media
    {
        return Media::create([
            'name' => $path,
            'hash' => $this->makeHash($path),
            'size' => Storage::disk('images')->size($path),
            'mime_type' => $mimeType,
        ]);
    }

    private function makeHash(string $path): string
    {
        return md5(Storage::disk($this->disk)->get($path));
    }

    public function hashExists(string $hash): ?Media
    {
        return Media::where('hash', $hash)->first();
    }

    public function setDisk(string $disk): MediaHandler
    {
        $this->disk = $disk;

        return $this;
    }
}