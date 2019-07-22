<?php

namespace Endeavors\Fhir\Support;

class Directory
{
    private $fileSystem;

    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;

        $this->fileSystem = new \Illuminate\Filesystem\Filesystem;

        if ($this->fileSystem->isFile($path)) {
            throw new \InvalidArgumentException(sprintf("The specific directory, %s, cannot be a file.", $path));
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

    public function exists()
    {
        return $this->fileSystem->exists($this->path);
    }

    public function isEmpty()
    {
        return "" === $this->get();
    }

    public function doesntExist()
    {
        return !$this->exists();
    }

    public function make()
    {
        if (false === $this->exists()) {
            // create the directory
            return $this->fileSystem->makeDirectory($this->path, 0755, true, true);
        }

        return false;
    }

    public function remove()
    {
        return $this->fileSystem->deleteDirectory($this->path);
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
