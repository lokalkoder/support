<?php

namespace Lokalkoder\Support\Services;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class LocalStorage
{
    const LOCAL_PATH = 'lokalkoder';
    
    private $path;

    /**
     * Initiate class
     *
     * @param string $path
     */
    public function __construct(string $path = null)
    {
        $this->path = $path ?? self::LOCAL_PATH;
        
        Storage::makeDirectory($this->path);
    }
    
    /**
     * Get generated file path.
     *
     * @param string $file
     *
     * @return string
     */
    public function getPath(string $file, string $name = null, string $ext = null): string
    {
        $file = new File($file);

        $path = Storage::putFileAs(
            $this->path,
            $file,
            ($name ?? $file->hashName()) . ($ext !== null ? '.' . $ext : null)
        );

        return storage_path('app/'.$path);
    }
}
