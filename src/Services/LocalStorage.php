<?php

namespace Lokalkoder\Support\Services;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class LocalStorage
{
    public const LOCAL_PATH = 'lokalkoder';

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
     * Check path is exist.
     *
     * @param string $filename
     * @param bool $public
     * @return bool
     */
    public function checkPath(string $filename, bool $public = false)
    {
        if ($public) {
            return is_file(public_path($this->path) . '/' . $filename);
        }

        return is_file($this->getLocalPath($this->path) . '/' . $filename);
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
        $path = $this->createFile($file, $name, $ext);

        return $this->getLocalPath($path);
    }

    /**
     * Get generated file path.
     *
     * @param string $file
     *
     * @return string
     */
    public function getPublicPath(string $file, string $name = null, string $ext = null): string
    {
        $path = $this->createFile($file, $name, $ext);

        $localPath = $this->getLocalPath($path);

        $filename = basename($path);

        if (!is_dir($publicDir = public_path($this->path))) {
            mkdir($publicDir);
        }

        $publicpath = $publicDir . '/' . $filename;

        if (is_file($localPath)) {
            rename($localPath, $publicpath);
        }

        return $path;
    }

    /**
     * @param string $file
     * @param string|null $name
     * @param string|null $ext
     * @return false|string
     */
    protected function createFile(string $file, ?string $name, ?string $ext)
    {
        $file = new File($file);

        $path = Storage::putFileAs(
            $this->path,
            $file,
            ($name ?? $file->hashName()) . ($ext !== null ? '.' . $ext : null)
        );
        return $path;
    }

    /**
     * @param $path
     * @return string
     */
    protected function getLocalPath($path): string
    {
        $localPath = storage_path('app/' . $path);
        return $localPath;
    }
}
