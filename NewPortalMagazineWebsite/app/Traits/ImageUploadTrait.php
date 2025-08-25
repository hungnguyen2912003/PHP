<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait ImageUploadTrait
{
    public function uploadImage(Request $request, string $field, ?string $oldImage = null, string $dir = 'uploads'): ?string
    {
        if (! $request->hasFile($field)) {
            return $oldImage;
        }

        $file = $request->file($field);

        if (! $file || ! $file->isValid()) {
            return $oldImage;
        }

        $uploadRoot = public_path($dir);

        if (! File::exists($uploadRoot)) {
            File::makeDirectory($uploadRoot, 0755, true);
        }

        $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

        $file->move($uploadRoot, $filename);

        if ($oldImage && file_exists(public_path($oldImage))) {
            @File::delete(public_path($oldImage));
        }

        return str_replace('\\', '/', trim($dir, '/') . '/' . $filename);
    }

    public function deleteImage(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            @File::delete(public_path($path));
        }
    }
}
