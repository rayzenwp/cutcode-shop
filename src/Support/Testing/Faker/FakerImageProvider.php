<?php declare(strict_types=1);

namespace Support\Testing\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class FakerImageProvider extends Base
{
    public function loremflickr(string $dir = '', int $width = 500, int $height = 500): string
    {
        $name = $dir. '/'.Str::random(6).'.jpg';

        Storage::put(
            $name,
            file_get_contents("https://loremflickr.com/$width/$height")
        );

        return '/storage/'.$name;
    }
      
    public function fixturesImage(string $fixturesDir, string $storageDir): string
    {
        if(!Storage::exists($storageDir)) {
            Storage::makeDirectory($storageDir);
        }
        //возможно это директорию нужно создать при рефреше что бы всегда точно была
        $file = $this->generator->file(
            base_path("tests/Fixtures/images/$fixturesDir"),
            Storage::path($storageDir),
            false
        );

        return '/storage/'.trim($storageDir, '/').'/'.$file;
    }
    
}