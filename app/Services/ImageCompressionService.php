<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageCompressionService
{
    protected $imageManager;

    public function __construct()
    {
        // Inisialisasi ImageManager dengan GD driver untuk Intervention Image v3
        $this->imageManager = new ImageManager(
            driver: Driver::class
        );
    }

    /**
     *
     *
     * @param UploadedFile
     * @param string
     * @param string
     * @param int
     * @return string
     */
    public function compressAndStore(UploadedFile $image, string $path = 'products', string $disk = 'public', int $targetSizeKb = 1024): string
    {

        $img = $this->imageManager->read($image->getRealPath());

        // Resize jika terlalu besar (max width 2000px)
        if ($img->width() > 2000) {
            $img->scaleDown(width: 2000);
        }

        // Kompresi adaptif berdasarkan target size
        $quality = 85;
        $compressed = $img->toJpeg(quality: $quality);
        $fileSizeKb = strlen($compressed) / 1024;


        while ($fileSizeKb > $targetSizeKb && $quality > 20) {
            $quality -= 5;
            $compressed = $img->toJpeg(quality: $quality);
            $fileSizeKb = strlen($compressed) / 1024;
        }

        // Simpan ke disk publik
        $filename = $image->hashName();
        $storagePath = $path . '/' . $filename;
        Storage::disk($disk)->put($storagePath, $compressed);

        return $storagePath;
    }

    /**
     * Kompresi gambar yang sudah ada
     *
     * @param string $imagePath
     * @param string $disk
     * @param int $targetSizeKb Target size dalam KB (default 1024 = 1MB)
     * @return void
     */
    public function compressExisting(string $imagePath, string $disk = 'public', int $targetSizeKb = 1024): void
    {
        $fullPath = Storage::disk($disk)->path($imagePath);

        if (file_exists($fullPath)) {
            $img = $this->imageManager->read($fullPath);

            if ($img->width() > 2000) {
                $img->scaleDown(width: 2000);
            }

            // Kompresi adaptif
            $quality = 85;
            $compressed = $img->toJpeg(quality: $quality);
            $fileSizeKb = strlen($compressed) / 1024;

            // Jika masih lebih besar dari target, turunkan quality
            while ($fileSizeKb > $targetSizeKb && $quality > 20) {
                $quality -= 5;
                $compressed = $img->toJpeg(quality: $quality);
                $fileSizeKb = strlen($compressed) / 1024;
            }

            Storage::disk($disk)->put($imagePath, $compressed);
        }
    }
}
