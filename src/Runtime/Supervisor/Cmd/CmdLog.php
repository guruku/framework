<?php

namespace Kraken\Runtime\Supervisor\Cmd;

use Kraken\Supervisor\SolverBase;
use Kraken\Supervisor\SolverInterface;
use Kraken\Log\Logger;
use Kraken\Log\LoggerInterface;
use Error;
use Exception;

class CmdLog extends SolverBase implements SolverInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     *
     */
    protected function construct()
    {
        if (!isset($this->context['level']))
        {
            $this->context['level'] = Logger::EMERGENCY;
        }

        $this->logger = $this->runtime->core()->make('Kraken\Log\LoggerInterface');
    }

    /**
     *
     */
    protected function destruct()
    {
        unset($this->logger);
    }

    /**
     * @param Error|Exception $ex
     * @param mixed[] $params
     * @return mixed
     */
    protected function handler($ex, $params = [])
    {
        $this->logger->log(
            $this->context['level'], \Kraken\Throwable\Exception::toString($ex)
        );
    }
}