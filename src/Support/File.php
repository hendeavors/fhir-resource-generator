<?php

namespace Endeavors\Fhir\Support;

use Endeavors\Fhir\Support\Contracts\FilePathInterface;

/**
 * Handle file existence creation
 */
class File implements FilePathInterface
{
    private $fileSystem;

    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;

        $this->fileSystem = new \Illuminate\Filesystem\Filesystem;

        if ($this->fileSystem->isDirectory($path)) {
            throw new \InvalidArgumentException(sprintf("The specified file, %s, cannot be a directory.", $path));
        }
    }

    public static function create(string $path)
    {
        return new static($path);
    }

    public function name()
    {
        return $this->fileSystem->name($this->path);
    }

    public function exactName()
    {
        return $this->fileSystem->basename($this->path);
    }

    public function extension()
    {
        return $this->fileSystem->extension($this->path);
    }

    public function exists()
    {
        return $this->fileSystem->exists($this->path);
    }

    public function doesntExist()
    {
        return !$this->exists();
    }

    public function get(): string
    {
        return (string)$this->path;
    }

    public function __toString()
    {
        return $this->get();
    }
}
