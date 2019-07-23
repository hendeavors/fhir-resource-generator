<?php

namespace Endeavors\Fhir\DataTypes;

use InvalidArgumentException;
use UnexpectedValueException;
/**
 * Validates a uri per rfc
 * https://tools.ietf.org/html/rfc3986#page-50
 */
class Uri
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $this->validate($value);
    }

    public static function create(string $value)
    {
        return new static($value);
    }

    public function get()
    {
        return (string)$this->value;
    }

    protected function validate($value)
    {
        preg_match('/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?/', $value, $matches);

        if ($this->hasValidScheme($matches[2]) && $this->hasValidAuthority($matches[4]) && $this->containsPath($matches[5])) {
            return $value;
        }

        throw new InvalidArgumentException(sprintf("The value, %s, is not a valid uri.", $value));
    }

    protected function hasValidScheme($scheme)
    {
        return 'http' === $scheme || 'https' === $scheme;
    }

    protected function hasValidAuthority($authority)
    {
        return @checkdnsrr($authority);
    }

    protected function containsPath($path)
    {
        return strlen($path) > 0;
    }
}
