<?php
declare(strict_types=1);

namespace App\Domain\Posts\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostImageService
{
    public function upload(UploadedFile $file, string $directory): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $subPath = now()->format('Y/m');

        Storage::disk('public')->putFileAs($directory . '/' . $subPath, $file, $filename);

        return $subPath . '/' . $filename;
    }

    public function delete(string $path, string $directory): void
    {
        Storage::disk('public')->delete($directory . '/' . $path);
    }
}
