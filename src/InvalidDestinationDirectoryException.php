<?php

namespace Endeavors\Fhir;

use InvalidArgumentException;
use Endeavors\Fhir\Support\Directory;

class InvalidDestinationDirectoryException extends InvalidArgumentException
{
    public static function invalidDestinationDirectoryPath(string $path)
    {
        return new static(sprintf("The destination directory, %s, is invalid. Please ensure you have a valid directory and try again.", $path ?? "null"));
    }

    public static function invalidDestinationDirectory(Directory $path)
    {
        if ($path->isEmpty()) {
            return static::emptyDestinationDirectory();
        }

        return static::invalidDestinationDirectoryPath($path->get());
    }

    public static function emptyDestinationDirectory()
    {
        return new static(sprintf("An empty destination directory is invalid. Please ensure you have a non-empty directory and try again."));
    }
}
