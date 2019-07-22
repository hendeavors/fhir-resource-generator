<?php

namespace Endeavors\Fhir;

class Server
{
    /**
     * This check is somewhat naive and is oblivious to namespaces
     * @return bool true if the server doesn't have the proper classes
     */
    public static function needsConfiguration(): bool
    {
        return class_exists('PHPFHIRGenerated\FHIRElement');
    }
}
