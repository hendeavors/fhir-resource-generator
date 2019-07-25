<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\GeneratorException;

class GeneratorResponse
{
    private $exception;

    private $message;

    public function __construct(GeneratorException $exception = null, string $message)
    {
        $this->exception = $exception;

        $this->message = $message;
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

        return $this->message;
    }

    public function print()
    {
        echo $this->get();
    }

    public function printOutput()
    {
        $this->print();
    }

    public function __toString()
    {
        return $this->get();
    }
}
