<?php

namespace Kraken\_Module\Console\Server\_Mock\Supervisor;

use Kraken\Runtime\RuntimeInterface;
use Kraken\Runtime\RuntimeModelInterface;
use Kraken\Supervisor\SolverBase;
use Kraken\Supervisor\SolverInterface;
use Error;
use Exception;

class ModelContinue extends SolverBase implements SolverInterface
{
    /**
     * @var RuntimeModelInterface|RuntimeInterface
     */
    protected $model;

    /**
     * @var string[]
     */
    protected $queue;

    /**
     * @param mixed[] $context
     */
    public function __construct($context = [])
    {
        $this->model =  $context['model'];
        $this->queue =& $context['queue'];

        parent::__construct($context);
    }

    /**
     *
     */
    public function __destruct()
    {
        parent::__destruct();

        unset($this->model);
        unset($this->queue);
    }

    /**
     * @param Error|Exception $ex
     * @param mixed[] $params
     * @return mixed
     */
    protected function handler($ex, $params = [])
    {
        $model = $this->model;
        $loop  = $model->getLoop();

        $loop->onTick(function() use($model) {
            $this->queue[] = 'C';
            $model->succeed();
        });
    }
}