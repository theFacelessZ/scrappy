<?php

namespace ScrappyTest\UpdateHandlers;

use Scrappy\SourceInterface;
use Scrappy\UpdateHandlerBase;

class CountHandler extends UpdateHandlerBase {

    /**
     * Public counter.
     *
     * @var int
     */
    public static $count = 0;

    /**
     * {@inheritDoc}
     */
    public function handle(SourceInterface $source)
    {
        // Iterate the counter.
        static::$count++;
    }

}
