<?php

namespace Endeavors\Fhir\Contracts;

interface FhirDefinitionVersionInterface
{
    const VERSION_10 = 'DSTU1';
    const VERSION_20 = 'DSTU2';
    const VERSION_30 = 'STU3';
    const VERSION_40 = 'R4';
    const VERSION_BUILD = 'BUILD';
}
