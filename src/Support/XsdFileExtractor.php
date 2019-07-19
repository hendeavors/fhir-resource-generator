<?php

declare(strict_types=1);

namespace Endeavors\Fhir\Support;

use Endeavors\Fhir\Support\Contracts;
use Endeavors\Fhir\Support\File;
use Endeavors\Fhir\Support\Zipper;

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
    // public function extractTo($path, array $files = [], $methodFlags = self::BLACKLIST)
    // {
    //     if (!$this->file->exists($path) && !$this->file->makeDirectory($path, 0755, true)) {
    //         throw new \RuntimeException('Failed to create folder');
    //     }
    //
    //     if ($methodFlags & self::EXACT_MATCH) {
    //         $matchingMethod = function ($haystack) use ($files) {
    //             return in_array($haystack, $files, true);
    //         };
    //     } else {
    //         $matchingMethod = function ($haystack) use ($files) {
    //             return starts_with($haystack, $files);
    //         };
    //     }
    //
    //     if ($methodFlags & self::WHITELIST) {
    //         $this->extractFilesInternal($path, $matchingMethod);
    //     } else {
    //         // blacklist - extract files that do not match with $matchingMethod
    //         $this->extractFilesInternal($path, function ($filename) use ($matchingMethod) {
    //             return !$matchingMethod($filename);
    //         });
    //     }
    // }

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
        if (!is_dir($sourceDirectory)) {
            throw new \InvalidArgumentException(sprintf("The directory, %s, is invalid. Please ensure you have a valid directory and try again.", $sourceDirectory));
        }

        $this->sourceDirectory = $this->cleanDirectory($sourceDirectory);

        return $this;
    }

    private $destinationDirectory;

    public function destinationDirectory(string $destinationDirectory)
    {
        if (!is_dir($destinationDirectory)) {
            throw new \InvalidArgumentException(sprintf("The directory, %s, is invalid. Please ensure you have a valid directory and try again.", $destinationDirectory));
        }

        $this->destinationDirectory = $this->cleanDirectory($destinationDirectory);

        return $this;
    }

    protected function cleanDirectory(string $directory)
    {
        $length = strlen($directory);

        if ($directory[$length-1] !== DIRECTORY_SEPARATOR) {
            $directory .= DIRECTORY_SEPARATOR;
        }

        return $directory;
    }

    public function extract(string $location, string $zipFile, array $files = []): string
    {
        $zipFile = $this->sourceDirectory . $zipFile;

        $location = $this->destinationDirectory . $location;

        $this->makeZip($zipFile);

        $this->zipper->extractTo($location, $files);
        // we'll assume all files?
        if (count($files) === 0) {
            $fileNames = [];

            foreach ($this->allFiles($zipFile) as $file) {
                $fileNames[] = $file->exactName();
            }

            $this->zipper->extractTo($location, $fileNames, 1);
        }

        //$this->zipper->close();
        return $location;
    }

    public function extractAll(string $location, string $zipFile)
    {
        return $this->extract($location, $zipFile);
    }

    public function extractOnly(string $location, string $zipFile, array $files = [])
    {
        $this->makeZip($zipFile);

        $this->zipper->extractTo($location, $zipFile, $files, 1);

        //$this->zipper->close();
    }

    public function extractExcept(string $location, string $zipFile, array $files = [])
    {
        $this->makeZip($zipFile);

        $this->zipper->extractTo($location, $zipFile, $files, 2);

        //$this->zipper->close();
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
