<?php

namespace Endeavors\Fhir\Support\Contracts;

use Endeavors\Fhir\Support\Directory;

interface ZipExtractionInterface
{
    /**
     * Extract the specified files
     * @param  string $path  [description]
     * @param  array  $files [description]
     * @return [type]        [description]
     */
    public function extract(string $zipFile, array $files): Directory;

    public function extractAll(string $zipFile): Directory;
}
