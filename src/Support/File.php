<?php

namespace Endeavors\Fhir\Support;

class File
{
    private $fileSystem;

    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;

        $this->fileSystem = new \Illuminate\Filesystem\Filesystem;
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
}
