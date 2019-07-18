<?php

namespace Endeavors\Fhir\Support\Contracts;

interface ZipExtractionInterface
{
    /**
     * Extract the specified files
     * @param  string $path  [description]
     * @param  array  $files [description]
     * @return [type]        [description]
     */
    public function extract(string $location, string $zipFile, array $files);

    public function extractAll(string $location, string $zipFile);

    public function extractOnly(string $location, string $zipFile, array $files);

    public function extractExcept(string $location, string $zipFile, array $files = []);
}
