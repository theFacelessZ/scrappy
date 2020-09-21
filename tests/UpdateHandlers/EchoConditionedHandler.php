<?php

namespace ScrappyTest\UpdateHandlers;

use Scrappy\SourceInterface;

class EchoConditionedHandler extends EchoHandler {

    /**
     * The condition callback.
     *
     * @var callable
     */
    protected $condition;

    /**
     * EchoConditionedHandler constructor.
     *
     * @param callable $condition
     *   Condition callable.
     */
    public function __construct(callable $condition)
    {
        $this->condition = $condition;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(SourceInterface $source)
    {
        if (call_user_func($this->condition, $source)) {
            parent::handle($source);
        }
    }

}
