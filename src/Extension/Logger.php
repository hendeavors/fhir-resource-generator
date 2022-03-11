<?php 

namespace Endeavors\Fhir\Extension;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Logger extends AbstractLogger
{
    /** @var LoggerInterface */
    protected $actualLogger;

    /** @var string */
    protected $breakLevel;

    /**
     * Logger constructor.
     * @param LoggerInterface $actualLogger
     * @param string $breakLevel
     */
    public function __construct(LoggerInterface $actualLogger, $breakLevel = LogLevel::WARNING)
    {
        $this->actualLogger = $actualLogger;
        $this->breakLevel = $breakLevel;
    }

    /**
     * @param string $action
     */
    public function startBreak($action)
    {
        $this->log($this->breakLevel, substr(sprintf('%\'-5s Start %s %1$-\'-75s', '-', $action), 0, 75));
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     */
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $this->actualLogger->log($level, $message, $context);
    }

    /**
     * @param string $action
     */
    public function endBreak($action)
    {
        $this->log($this->breakLevel, substr(sprintf('%\'-5s End %s %1$-\'-75s', '-', $action), 0, 75));
    }
}