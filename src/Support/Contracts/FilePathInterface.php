<?php

namespace Endeavors\Fhir\Support\Contracts;

interface FilePathInterface
{
    /**
     * Gets the file path as a string
     * 
     * @return string
     */
    public function get(): string;
}
