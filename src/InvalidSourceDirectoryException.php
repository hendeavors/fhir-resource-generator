<?php

namespace Endeavors\Fhir;

use InvalidArgumentException;
use Endeavors\Fhir\Support\Directory;

/**
 * @todo rename to InvalidDirectoryException
 */
class InvalidSourceDirectoryException extends InvalidArgumentException
{
    public static function invalidSourceDirectoryPath(string $path)
    {
        return new static(sprintf("The source directory, %s, is invalid. Please ensure you have a valid directory and try again.", $path ?? "null"));
    }

    public static function invalidSourceDirectory(Directory $path)
    {
        if ($path->isEmpty()) {
            return static::emptyDirectory();
        }

        return static::invalidSourceDirectoryPath($path->get());
    }

    public static function emptyDirectory()
    {
        return new static(sprintf("An empty directory is invalid. Please ensure you have a non-empty directory and try again."));
    }
}
