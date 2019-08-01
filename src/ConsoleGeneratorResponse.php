<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\GeneratorException;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleGeneratorResponse
{
    private $output;

    private $response;

    public function __construct(OutputInterface $output, GeneratorResponse $response)
    {
        $this->output = $output;

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
            $this->output->writeln(sprintf("<error>%s</error>", $this->get()));
        } else {
            $this->output->writeln(sprintf("<info>%s</info>", $this->get()));
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
