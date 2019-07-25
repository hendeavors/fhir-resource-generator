<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\GeneratorException;
use Symfony\Component\Console\Output\ConsoleOutput;

class ConsoleGeneratorResponse
{
    private $console;

    private $response;

    public function __construct(ConsoleOutput $console, GeneratorResponse $response)
    {
        $this->console = $console;

        $this->response = $response;
    }

    public function succeeds()
    {
        return $this->response->succeeds();
    }

    public function fails()
    {
        return $this->response->fails();
    }

    public function get()
    {
        return $this->response->get();
    }

    public function print()
    {
        if ($this->fails()) {
            $this->console->writeln(sprintf("<error>%s</error>", $this->get()));
        } else {
            $this->console->writeln(sprintf("<info>%s</info>", $this->get()));
        }
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
