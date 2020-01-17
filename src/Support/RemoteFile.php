<?php

declare(strict_types=1);

namespace Endeavors\Fhir\Support;

use Endeavors\Fhir\Support\Contracts;
use Endeavors\Fhir\Support\File;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Support\Zipper;
use Endeavors\Fhir\InvalidSourceFileException;
use Endeavors\Fhir\InvalidDestinationDirectoryException;
use Endeavors\Fhir\DownloadError;

class RemoteFile
{
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function create(string $url)
    {
        return new static($url);
    }

    /**
     * Download the file from a remote location
     * @param  File   $file wraps a filepath
     * @return string path to file downloaded
     */
    public function download(File $file)
    {
        if ($file->exists() && $file->directory($file->name())->doesntExist()) {
            $file->directory($file->name())->make();

            return $file->get();
        }
        
        // don't re-download the file
        if ($file->exists()) {
            return $file->get();
        }

        $file->directory()->make();

        if ($file->directory()->doesntExist()) {
            throw InvalidDestinationDirectoryException::invalidDestinationDirectory($file->directory());
        }

        $copyResult = @copy($this->url, $file->get());

        if (false == $copyResult) {
            $copyResult = @copy($this->url, $file->real());
        }

        if (true === $copyResult) {
            // make the directory for file extractions
            $file->directory($file->name())->make();

            return $file->get();
        }

        throw new DownloadError("The file failed to download.");
    }
}
