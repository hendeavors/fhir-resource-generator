<?php 

namespace Endeavors\Fhir\Extension;

use DCarbone\PHPFHIR\ClassGenerator\Config as BaseConfig;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Endeavors\Fhir\Extension\Logger;


/**
 * Class Config
 * @package DCarbone\PHPFHIR\ClassGenerator
 */
class Config extends BaseConfig
{
    /** @var string */
    private $xsdPath;
    
    /**
     * Config constructor.
     * @param array $conf
     * @param \Psr\Log\LoggerInterface|null $logger
     */
    public function __construct(array $conf = [], LoggerInterface $logger = null)
    {
        if ($logger) {
            $this->logger = new Logger($logger);
        } else {
            $this->logger = new Logger(new NullLogger());
        }

        foreach ($conf as $k => $v) {
            $this->{'set' . ucfirst($k)}($v);
        }

        // be lazy...
        $this->setXsdPath(isset($this->xsdPath) ? $this->xsdPath : null);
    }

    /**
     * @return string
     */
    public function getXsdPath()
    {
        return $this->xsdPath;
    }

    /**
     * @param string $xsdPath
     * @return \DCarbone\PHPFHIR\ClassGenerator\Config
     */
    public function setXsdPath($xsdPath)
    {
        // Bunch'o validation
        if (false === is_dir($xsdPath)) {
            throw new \RuntimeException('Unable to locate XSD dir "' . $xsdPath . '"');
        }
        if (false === is_readable($xsdPath)) {
            throw new \RuntimeException('This process does not have read access to directory "' . $xsdPath . '"');
        }
        $this->xsdPath = rtrim($xsdPath, "/\\");
        return $this;
    }
}