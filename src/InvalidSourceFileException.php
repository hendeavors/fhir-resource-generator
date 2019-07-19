<?php

namespace Endeavors\Fhir;

use InvalidArgumentException;
use Endeavors\Fhir\Support\Contracts\FilePathInterface;

class InvalidSourceFileException extends InvalidArgumentException
{
    public static function invalidSourceFilePath(string $path)
    {
        return new static(sprintf("The source file, %s, is invalid. Please ensure you have a valid source file and try again.", $path));
    }

    public static function invalidSourceFile(FilePathInterface $path)
    {
        return static::invalidSourceFilePath($path->get());
    }
}
