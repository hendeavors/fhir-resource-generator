<?php

namespace Endeavors\Fhir\Support\Contracts;

interface ZipArchiveInterface
{
    /**
     * Get all the files in a zip archive
     * @param  string $path  [description]
     * @param  array  $files [description]
     * @return [type]        [description]
     */
    public function allFiles(string $pathToZipArchive);
}
