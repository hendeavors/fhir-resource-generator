<?php

namespace Endeavors\Fhir\Support;

use Chumper\Zipper\Zipper as BaseZipper;

class Zipper extends BaseZipper
{
    public function __destruct()
    {
        if (is_object($this->getRepository())) {
            parent::__destruct();
        }
    }
}
