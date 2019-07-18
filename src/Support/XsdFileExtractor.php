<?php

namespace Endeavors\Fhir\Support;

use Endeavors\Fhir\Support\Contracts;
use Endeavors\Fhir\Support\File;
use Chumper\Zipper\Zipper;

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

    public function extract(string $location, string $zipFile, array $files = [])
    {
        $this->makeZip($zipFile);

        $this->zipper->extractTo($location, $files);
        // we'll assume all files?
        if (count($files) === 0) {
            $fileNames = [];

            foreach($this->allFiles($zipFile) as $file) {
                $fileNames[] = $file->exactName();
            }

            $this->zipper->extractTo($location, $fileNames, 1);
        }

        //$this->zipper->close();
        return $location;
    }

    public function extractAll(string $location, string $zipFile)
    {
        $this->extract($location, $zipFile);
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

        $repository->each(function($file) use(&$fileNames) {
            $fileNames[] = File::create($file);
        });

        return $fileNames;
    }

    protected function makeZip($path)
    {
        if (false === $this->isZipped) {
            try {
                $this->zipper->make($path);

                $this->isZipped = true;
            } catch(\Throwable $ex) {

            }
        }
    }

}
