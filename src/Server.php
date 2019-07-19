<?php

namespace Endeavors\Fhir;

class Server
{
    public static function needsConfiguration(): bool
    {
        return class_exists('PHPFHIRGenerated\FHIRElement');
    }
}
