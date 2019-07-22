<?php

declare(strict_types=1);

namespace Endeavors\Fhir\Support;

use Endeavors\Fhir\Support\Contracts;
use Endeavors\Fhir\Support\File;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Support\Zipper;
use Endeavors\Fhir\InvalidSourceFileException;
use Endeavors\Fhir\InvalidDestinationDirectoryException;

class XsdFileExtractor implements Contracts\ZipExtractionInterface, Contracts\ZipArchiveInterface
{
    private $zipper;

    private $isZipped = false;

//     require __DIR__.'/vendor/autoload.php';
//
    // $xsdPath = 'path to wherever you un-zipped the xsd files';
//
    // $generator = new \DCarbone\PHPFHIR\ClassGenerator\Generator($xsdPath);
//
    // $generator->generate();

    // const WHITELIST = 1;
    //
    // /**
    //  * Constant for extracting
    //  */
    // const BLACKLIST = 2;
    //
    // /**
    //  * Constant for matching only strictly equal file names
    //  */
    // const EXACT_MATCH = 4;
    //


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

        $this->sourceDirectory = $this->cleanDirectory($sourceDirectory);

        return $this;
    }

    public function getSourceDirectory()
    {
        return Directory::create($this->sourceDirectory ?? "");
    }

    private $destinationDirectory;

    public function destinationDirectory(string $destinationDirectory)
    {
        Directory::create($destinationDirectory)->make();

        if (Directory::create($destinationDirectory)->doesntExist()) {
            throw new InvalidDestinationDirectoryException(sprintf("The destination directory, %s, is invalid. Please ensure you have a valid directory and try again.", $destinationDirectory));
        }

        $this->destinationDirectory = $this->cleanDirectory($destinationDirectory);

        return $this;
    }

    public function getDestinationDirectory()
    {
        return Directory::create($this->destinationDirectory ?? "");
    }

    protected function cleanDirectory(string $directory)
    {
        $length = strlen($directory);

        if ($directory[$length-1] !== DIRECTORY_SEPARATOR) {
            $directory .= DIRECTORY_SEPARATOR;
        }

        return $directory;
    }

    public function extract(string $zipFile, array $files = []): string
    {
        $zipFile = $this->sourceDirectory . $zipFile;

        $zipFile = File::create($zipFile);

        $this->makeZip($zipFile);

        if ($zipFile->doesntExist()) {
            throw InvalidSourceFileException::invalidSourceFile($zipFile);
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

        return $this->getDestinationDirectory()->get();
    }

    public function extractAll(string $zipFile)
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
