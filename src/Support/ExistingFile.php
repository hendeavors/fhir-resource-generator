<?php

namespace Endeavors\Fhir\Support;

use Endeavors\Fhir\Support\File;
use Endeavors\Fhir\Support\Contracts\FilePathInterface;
use Endeavors\Fhir\InvalidSourceFileException;

/**
 * Handle file existence creation
 */
class ExistingFile implements FilePathInterface
{
    private $file;

    public function __construct(string $path)
    {
        $this->file = File::create($path);

        if ($this->file->doesntExist()) {
            throw new InvalidSourceFileException(sprintf("The file, %s, doesn't exist", $path));
        }
    }

    public static function create(string $path)
    {
        return new static($path);
    }

    public function name()
    {
        return $this->file->name();
    }

    public function exactName()
    {
        return $this->file->exactName();
    }

    public function extension()
    {
        return $this->file->extension();
    }

    public function exists()
    {
        return $this->file->exists();
    }

    public function doesntExist()
    {
        return !$this->exists();
    }

    public function get(): string
    {
        return (string)$this->file->get();
    }

    public function __toString()
    {
        return $this->get();
    }
}
