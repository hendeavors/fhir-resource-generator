<?php

namespace Endeavors\Fhir\Contracts;

interface FhirDefinitionVersionLocationInterface
{
    const VERSION_10 = 'http://hl7.org/fhir/DSTU1/fhir-all-xsd.zip';
    const VERSION_20 = 'http://hl7.org/fhir/DSTU2/fhir-all-xsd.zip';
    const VERSION_30 = 'http://hl7.org/fhir/STU3/fhir-all-xsd.zip';
    const VERSION_40 = 'http://hl7.org/fhir/R4/fhir-all-xsd.zip';
    const VERSION_BUILD = 'http://build.fhir.org/fhir-all-xsd.zip';
}
