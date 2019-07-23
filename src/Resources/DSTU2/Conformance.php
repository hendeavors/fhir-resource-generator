<?php

namespace Endeavors\Fhir\Resources\DSTU2;

use UnexpectedValueException;
use Endeavors\Fhir\DataTypes\Uri;

class Conformance
{
    private $attributes;

    private $resource;

    public function __construct(string $json)
    {
        $this->resource = $this->validate($json);

        $this->mapResource();
    }

    public function getUrl()
    {

    }

    public function getName()
    {

    }

    public function getVersion()
    {

    }

    public function getStatus()
    {

    }

    public function setUrl(string $url)
    {
        $this->attributes['url'] = $url;

        return $this;
    }

    public function getOriginal()
    {
        return $this->resource;
    }

    public function asOriginal()
    {
        return $this->resource;
    }

    protected function mapResource()
    {
        $this->url = Uri::create($this->resource->url) ?? "";
        $this->version = $this->resource->version ?? "";
        $this->name = $this->resource->name ?? "";
        $this->status = $this->resource->status ?? "";
        $this->experimental = $this->resource->experimental ?? "";
        $this->publisher = $this->resource->publisher ?? "";
        $this->software = $this->resource->software ?? "";
        $this->contact = $this->resource->contact ?? "";
        $this->fhirVersion = $this->resource->fhirVersion ?? "";
        $this->acceptUnknown = $this->resource->acceptUnknown ?? "";
        $this->rest = $this->resource->rest->mode ?? "";
    }

    protected function validate(string $json)
    {
        $json = json_decode($json);

        if (null === $json) {
            throw new UnexpectedValueException("Received malformed json.");
        }

        return $json;
    }

    public function __get($arg)
    {
        return $this->attributes[$arg] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
