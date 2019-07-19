<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\GeneratorException;

class GeneratorResponse
{
    private $exception;

    public function __construct(GeneratorException $exception = null)
    {
        $this->exception = $exception;
    }

    public function succeeds()
    {
        return null === $this->exception;
    }

    public function fails()
    {
        return !$this->succeeds();
    }

    public function get()
    {
        if ($this->fails()) {
            return $this->exception->getMessage();
        }

        return "Generator task completed without error.";
    }

    public function __toString()
    {
        return $this->get();
    }
}
