<?php

declare(strict_types=1);

namespace Endeavors\Fhir\Support;

use Endeavors\Fhir\Support\Contracts;
use Endeavors\Fhir\Support\File;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Support\Zipper;
use Endeavors\Fhir\InvalidSourceFileException;
use Endeavors\Fhir\InvalidDestinationDirectoryException;

class CompressedFile implements Contracts\ZipExtractionInterface, Contracts\ZipArchiveInterface
{
    private $zipper;

    public function __construct(Zipper $zipper)
    {
        $this->zipper = $zipper;
    }

    public static function create()
    {
        return new static(new Zipper());
    }

    private $sourceDirectory;

    public function sourceDirectory(string $sourceDirectory)
    {
        Directory::create($sourceDirectory)->make();

        if (Directory::create($sourceDirectory)->doesntExist()) {
            throw new InvalidSourceFileException(sprintf("The source directory, %s, is invalid. Please ensure you have a valid directory and try again.", $sourceDirectory));
        }

        $this->sourceDirectory = Directory::create($this->cleanDirectory($sourceDirectory) ?? "");

        return $this;
    }

    public function getSourceDirectory()
    {
        return $this->sourceDirectory ?? Directory::create("");
    }

    private $destinationDirectory;

    public function destinationDirectory(string $destinationDirectory)
    {
        Directory::create($destinationDirectory)->make();

        if (Directory::create($destinationDirectory)->doesntExist()) {
            throw new InvalidDestinationDirectoryException(sprintf("The destination directory, %s, is invalid. Please ensure you have a valid directory and try again.", $destinationDirectory));
        }

        $this->destinationDirectory = Directory::create($this->cleanDirectory($destinationDirectory) ?? "");

        return $this;
    }

    public function getDestinationDirectory(): Directory
    {
        return $this->destinationDirectory ?? Directory::create("");
    }

    protected function cleanDirectory(string $directory)
    {
        $length = strlen($directory);

        if ($directory[$length-1] !== DIRECTORY_SEPARATOR) {
            $directory .= DIRECTORY_SEPARATOR;
        }

        return $directory;
    }

    public function extract(string $zipFile, array $files = []): Directory
    {
        $zipFile = $this->sourceDirectory . $zipFile;

        $zipFile = File::create($zipFile);

        $this->makeZip($zipFile);

        if ($zipFile->doesntExist()) {
            throw InvalidSourceFileException::invalidSourceFile($zipFile);
        }

        if ($this->getDestinationDirectory()->doesntExist()) {
            // default to the files directory using the file name
            $this->destinationDirectory = $zipFile->directory($zipFile->name());
        }

        if ($this->getDestinationDirectory()->doesntExist()) {
            throw InvalidDestinationDirectoryException::invalidDestinationDirectory($this->getDestinationDirectory());
        }

        $this->zipper->extractTo($this->getDestinationDirectory(), $files);
        // we'll assume all files?
        if (count($files) === 0) {
            $fileNames = [];

            foreach ($this->allFiles($zipFile->get()) as $file) {
                $fileNames[] = $file->exactName();
            }

            $this->zipper->extractTo($this->getDestinationDirectory(), $fileNames, 1);
        }

        return $this->getDestinationDirectory();
    }

    public function extractAll(string $zipFile): Directory
    {
        return $this->extract($zipFile);
    }

    public function allFiles(string $zipFile): array
    {
        $this->makeZip($zipFile);

        $fileNames = [];

        $repository = $this->zipper->getRepository();

        if (null === $repository) {
            return [];
        }

        $repository->each(function ($file) use (&$fileNames) {
            $fileNames[] = File::create($file);
        });

        return $fileNames;
    }

    protected function makeZip($path): bool
    {
        $zipped = false;

        try {
            $this->zipper->make($path);

            $zipped = true;
        } catch (\Exception $ex) {
            $zipped = false;
        } catch (\Throwable $ex) {
            $zipped = false;
        } finally {
            return $zipped;
        }
    }
}
