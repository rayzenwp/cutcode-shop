<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

// NOTE: можно делать через мидлвай
// 
class ThumbnailController extends Controller
{
    public function __invoke(string $dir, string $method, string $size, string $file): BinaryFileResponse
    {
        abort_if(!in_array($size, config('thumbnail.allowed_sizes', [])), 403, 'Size not allowed');

        $storage = Storage::disk('images');

        $realPath = "$dir/$file";

        $newDirPath = "$dir/$method/$size";

        $resultPath = "$newDirPath/$file";

        if (!$storage->exists($newDirPath)) {
            $storage->makeDirectory($newDirPath);
        }

        // TODO: добавить удаление файлов (чистка старых)
        // должно быть ещ разделение на папки с датами иначе вся директория продуктс например будет долго грузится
        // try catch

        if (!$storage->exists($resultPath)) {
            $image = Image::make($storage->path($realPath));

            [$w, $h] = explode('x', $size);

            $image->{$method}($w, $h);
            $image->save($storage->path($resultPath));
        }

        return response()->file($storage->path($resultPath));
    }
}
