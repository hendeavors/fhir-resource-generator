# fhir-resource-generator
Generate fhir resources into php classes using Laravel Artisan commands

# Installation
`composer require endeavors/fhir-resource-generator`

# Commands

## Generate
`php artisan fhir:resources.generate --{fhirversion}` .  
<br/>**Note:** If a fhirversion is not provided all versions will be generated.
## Clean 
`php artisan fhir:resources.clean --{fhirversion}` .  
<br/>**Note:** If a fhirversion is not provided all versions will be cleaned.

